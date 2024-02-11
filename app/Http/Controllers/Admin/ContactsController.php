<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Contact;
use App\Models\Favorite;
use App\Models\Metric;
use App\Models\Network;
use App\Models\Outreach;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ContactsController extends Controller
{
    private $menu = 'Contacts';

    public function __construct()
    {
        View::share('menu', $this->menu);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type = $request['type'];
        if (!in_array($type, ['brand', 'creator'])) {
            return redirect()->route('admin.contacts.index', ['type' => 'brand']);
        }
        $contacts = Contact::query()
            ->with(['feedbacks'])
            ->where(function ($query) use ($type) {
                if ($type == 'brand') $query->where('type', 'Brand');
                else $query->where('type', 'Creator');
            })
            ->orderBy('featured', 'desc')
            ->orderBy('active', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        foreach ($contacts as $contact) {
            $average_response = $number = 0;
            foreach ($contact['feedbacks'] as $feedback) {
                if ($feedback['response_time'] >= 1) {
                    $average_response += $feedback['response_time'];
                    $number++;
                }
            }
            if ($number) $average_response = ceil($average_response / $number);
            $contact['average'] = $average_response;
        }
        return view("admin.contacts.{$type}.index", [
            'submenu'  => $type,
            'contacts' => $contacts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = $request['type'];
        if (!in_array($type, ['brand', 'creator'])) {
            return back();
        }
        $networks = Network::query()->get();
        $users = User::query()
            ->doesntHave('contact')
            ->where(function ($query) use ($type) {
                if ($type == 'brand') $query->where('type', 'Brand');
                else $query->where('type', 'Creator');
            })
            ->active()
            ->select(['id', 'name', 'email'])
            ->get();
        $info = [
            'name' => old('name'),
            'email' => old('email'),
        ];
        $metrics = $user_metrics = [];
        if ($type == 'creator') {
            $metrics = Metric::query()->get();
        }
        return view("admin.contacts.{$type}.edit", [
            'submenu'   => $type,
            'networks'  => $networks,
            'users'     => $users,
            'info'      => $info,
            'metrics'   => $metrics,
            'user_metrics' => $user_metrics,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = $request['type'];
        if (!in_array($type, ['brand', 'creator'])) {
            return back();
        }
        $brand = $type == 'brand';
        $owner = $request['owner'];
        $rule = [
            'owner' => $owner ? ['exists:users,id'] : [],
            'email' => !$owner ? ['required', 'email'] : [],
            'name'  => !$owner ? ['required'] : [],
        ];
        if ($brand) {
            $rule['brand_url'] = ['required', 'url'];
            if ($request->hasFile('logo')) {
                $rule['logo'] = ['image'];
            }
            if ($request['network']) {
                $rule['network'] = ['exists:networks,id'];
            } else {
                $rule['network_name'] = ['required'];
                $rule['network_link'] = ['required', 'url'];
            }
            if ($request['commission']) {
                $rule['commission'] = ['required', 'numeric'];
                $rule['commission_type'] = ['required', 'in:dollar,percentage'];
                $rule['commission_unit'] = ['required', 'in:Per Sale,Per Lead,Per Sign Up,custom'];
                $rule['commission_custom_unit'] = ['required_if:commission_unit,custom'];
            }
            if ($request['exclusive_deal'] = str_replace('{USERID}', '+USERID+', $request['exclusive_deal'])) {
                $rule['exclusive_deal'] = ['url'];
            }
        } else {
            $rule['website'] = ['required', 'url'];
            $metrics = Metric::query()->get();
            foreach ($metrics as $metric) {
                if ($request['metric'.$metric['id']]) {
                    $rule['metric'.$metric['id']] = ['metric:'.strtolower($metric['type'])];
                }
            }
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $website = $brand ? $request['brand_url'] : $request['website'];
        $domain = $request['domain'] = getDomain($website, $influencer);
        if ($influencer && $brand) {
            $validator->errors()->add('domain', 'The brand url field is invalid URL.');
            return back()->withErrors($validator)->withInput();
        }
        $rule = [
            'domain' => ['required', 'unique:contacts,domain'],
        ];
        $validator = Validator::make($request->all(), $rule, [
            'domain.required'   => $influencer ? 'Social media URL must be valid URL.'
                                    : 'This domain could not be found. Please check again.',
            'domain.unique'     => 'This domain has already been taken.',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $name = $request['name'];
        $email = $request['email'];
        $logo =
        $network_id =
        $network =
        $network_link =
        $commission =
        $commission_type =
        $commission_unit =
        $exclusive_deal =
        $code = null;
        if ($owner) {
            $user = User::query()
                ->doesntHave('contact')
                ->where('id', $owner)
                ->where(function ($query) use ($brand) {
                    if ($brand) $query->where('type', 'Brand');
                    else $query->where('type', 'Creator');
                })
                ->active()
                ->first();
            if (!$user) {
                $which = $brand ? 'brand' : 'creator';
                $validator->errors()->add('owner', "The {$which} cannot be added to this user.");
                return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
            }
            $name = $user['name'];
            $email = $user['email'];
            $contact = $user->contact();
        } else {
            $contact = auth('admin')->user()->contacts();
        }
        if ($brand) {
            if ($request->hasFile('logo')) {
                $logo = 'uploads/'.$request->file('logo')->store('brands');
            }
            if ($request['network']) {
                $n = Network::find($request['network']);
                $network_id = $n['id'];
                $network = $n['name'];
                $network_link = $n['link'];
            } else {
                $network_id = null;
                $network = $request['network_name'];
                $network_link = $request['network_link'];
            }
            if ($request['commission']) {
                $commission = $request['commission'];
                $commission_type = $request['commission_type'] == 'dollar' ? '$' : '%';
                $commission_unit = $request['commission_unit'] == 'custom' ? $request['commission_custom_unit'] : $request['commission_unit'];
            }
            $exclusive_deal = str_replace('+USERID+', '{USERID}', $request['exclusive_deal']);
            if (empty($exclusive_deal)) $exclusive_deal = null;
            do {
                $code = Str::random(8);
            } while (Contact::query()->where('code', $code)->exists());
        } else {
            $offers = !empty($request['offers']);
            $posts = !empty($request['posts']);
        }
        $tags = implode(',', preg_split('/\s*,\s*/', $request['tags'], -1, PREG_SPLIT_NO_EMPTY));
        $contact = $contact->create([
            'type'          => ucfirst($type),
            'name'          => $name,
            'email'         => $email,
            'website'       => $website,
            'domain'        => $domain,
            'logo'          => $logo,
            'network_id'    => $network_id,
            'network'       => $network,
            'network_link'  => $network_link,
            'tags'          => $tags ? ','.$tags.',' : null,
            'commission'      => $commission,
            'commission_type' => $commission_type,
            'commission_unit' => $commission_unit,
            'exclusive_deal'  => $exclusive_deal,
            'code'          => $code,
            'offers'        => !empty($offers),
            'posts'         => !empty($posts),
            'active'        => !empty($request['active']),
            'featured'      => !empty($request['featured']),
        ]);
        if (!$brand) {
            foreach ($metrics as $metric) {
                if ($value = $request['metric'.$metric['id']]) {
                    $value = strtoupper($value);
                    $number = short_format_number($value);
                    $contact->metrics()->create([
                        'metric_id' => $metric['id'],
                        'value' => $value,
                        'number' => $number,
                    ]);
                }
            }
        }
        return redirect()->route('admin.contacts.index', ['type' => $type])->with('info_message', 'Successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contact = Contact::with('user')->find($id);
        if (!$contact) {
            return back()->with('error_message', 'Cannot find contact information.');
        }
        $type = strtolower($contact['type']);
        $networks = Network::get();
        $users = User::query()->whereDoesntHave('contact', function (Builder $query) use ($contact) {
                $query->where('id', '<>', $contact['id']);
            })
            ->where(function ($query) use ($type) {
                if ($type == 'brand') $query->where('type', 'Brand');
                else $query->where('type', 'Creator');
            })
            ->active()
            ->select(['id', 'name', 'email'])
            ->get();
        $info = [
            'name' => $contact['name'],
            'email' => $contact['email'],
        ];
        $metrics = $user_metrics = [];
        if ($type == 'creator') {
            $metrics = Metric::query()->get();
            $user_metrics = $contact->metrics()
                ->pluck('value', 'metric_id');
        }
        return view("admin.contacts.{$type}.edit", [
            'submenu'   => $type,
            'contact'   => $contact,
            'networks'  => $networks,
            'users'     => $users,
            'info'      => $info,
            'metrics'   => $metrics,
            'user_metrics' => $user_metrics,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $contact = Contact::query()->find($id);
        if (!$contact) {
            return back()->with('error_message', 'Cannot find contact information.');
        }
        $brand = strtolower($contact['type']) == 'brand';
        $update_owner = ($owner = $request['owner']) != $contact['owner_id']
                            || $contact['owner_type'] == Admin::class;
        $rule = [];
        if ($update_owner) {
            $rule = [
                'owner' => $owner ? ['exists:users,id'] : [],
                'email' => !$owner ? ['required', 'email'] : [],
                'name'  => !$owner ? ['required'] : [],
            ];
        }
        if ($brand) {
            $rule['brand_url'] = ['required', 'url'];
            if ($request->hasFile('logo')) {
                $rule['logo'] = ['image'];
            }
            if ($request['network']) {
                $rule['network'] = ['exists:networks,id'];
            } else {
                $rule['network_name'] = ['required'];
                $rule['network_link'] = ['required', 'url'];
            }
            if ($request['commission']) {
                $rule['commission'] = ['required', 'numeric'];
                $rule['commission_type'] = ['required', 'in:dollar,percentage'];
                $rule['commission_unit'] = ['required', 'in:Per Sale,Per Lead,Per Sign Up,custom'];
                $rule['commission_custom_unit'] = ['required_if:commission_unit,custom'];
            }
            if ($request['exclusive_deal'] = str_replace('{USERID}', '+USERID+', $request['exclusive_deal'])) {
                $rule['exclusive_deal'] = ['url'];
            }
        } else {
            $rule['website'] = ['required', 'url'];
            $metrics = Metric::get();
            foreach ($metrics as $metric) {
                if ($request['metric'.$metric['id']]) {
                    $rule['metric'.$metric['id']] = ['metric:'.strtolower($metric['type'])];
                }
            }
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $website = $brand ? $request['brand_url'] : $request['website'];
        $domain = $contact['domain'];
        if ($website != $contact['website']) {
            $domain = $request['domain'] = getDomain($website, $influencer);
            if ($influencer && $brand) {
                $validator->errors()->add('domain', 'The brand url field is invalid URL.');
                return back()->withErrors($validator)->withInput();
            }
            $rule = [
                'domain' => ['required', Rule::unique('contacts', 'domain')->ignore($contact['id'])],
            ];
            $validator = Validator::make($request->all(), $rule, [
                'domain.required'   => $influencer ? 'Social media URL must be valid URL.'
                                        : 'This domain could not be found. Please check again.',
                'domain.unique'     => 'This domain has already been taken.',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
            }
        }
        $owner_id           = $contact['owner_id'];
        $owner_type         = $contact['owner_type'];
        $name               = $contact['name'];
        $email              = $contact['email'];
        $logo               = $contact['logo'];
        $network_id         = $contact['network_id'];
        $network            = $contact['network'];
        $network_link       = $contact['network_link'];
        $commission         = $contact['commission'];
        $commission_type    = $contact['commission_type'];
        $commission_unit    = $contact['commission_unit'];
        $exclusive_deal     = $contact['exclusive_deal'];
        if ($update_owner) {
            if ($owner) {
                $user = User::query()
                    ->doesntHave('contact')
                    ->where('id', $owner)
                    ->where(function ($query) use ($brand) {
                        if ($brand) $query->where('type', 'Brand');
                        else $query->where('type', 'Creator');
                    })
                    ->active()
                    ->first();
                if (!$user) {
                    $which = $brand ? 'brand' : 'creator';
                    $validator->errors()->add('owner', "The {$which} cannot be added to this user.");
                    return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
                }
                $owner_id = $user['id'];
                $owner_type = User::class;
            } else {
                $owner_id = auth('admin')->id();
                $owner_type = Admin::class;
            }
            $name = $user['name'] ?? $request['name'];
            $email = $user['email'] ?? $request['email'];
        }
        if ($brand) {
            if ($request->hasFile('logo')) {
                if ($contact['logo'] && file_exists(public_path($contact['logo']))) {
                    unlink(public_path($contact['logo']));
                }
                $logo = 'uploads/'.$request->file('logo')->store('brands');
            }
            if ($request['network']) {
                $n = Network::find($request['network']);
                $network_id = $n['id'];
                $network = $n['name'];
                $network_link = $n['link'];
            } else {
                $network_id = null;
                $network = $request['network_name'];
                $network_link = $request['network_link'];
            }
            if ($request['commission']) {
                $commission = $request['commission'];
                $commission_type = $request['commission_type'] == 'dollar' ? '$' : '%';
                $commission_unit = $request['commission_unit'] == 'custom' ? $request['commission_custom_unit'] : $request['commission_unit'];
            }
            $exclusive_deal = str_replace('+USERID+', '{USERID}', $request['exclusive_deal']);
        } else {
            $offers = !empty($request['offers']);
            $posts = !empty($request['posts']);
        }
        $tags = implode(',', preg_split('/\s*,\s*/', $request['tags'], -1, PREG_SPLIT_NO_EMPTY));
        $contact->update([
            'owner_id'      => $owner_id,
            'owner_type'    => $owner_type,
            'name'          => $name,
            'email'         => $email,
            'website'       => $website,
            'domain'        => $domain,
            'logo'          => $logo,
            'network_id'    => $network_id,
            'network'       => $network,
            'network_link'  => $network_link,
            'tags'          => $tags ? ','.$tags.',' : null,
            'commission'      => $commission,
            'commission_type' => $commission_type,
            'commission_unit' => $commission_unit,
            'exclusive_deal'  => $exclusive_deal,
            'offers'        => !empty($offers),
            'posts'         => !empty($posts),
            'active'        => !empty($request['active']),
            'featured'      => !empty($request['featured']),
        ]);
        if (!$brand) {
            foreach ($metrics as $metric) {
                if ($number = $value = $request['metric'.$metric['id']]) {
                    $value = strtoupper($value);
                    $number = short_format_number($value);
                }
                $contact->metrics()->updateOrCreate([
                    'metric_id' => $metric['id']
                ], [
                    'value' => $value,
                    'number' => $number,
                ]);
            }
        }
        return back()->with('info_message', 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contact = Contact::query()->find($id);
        if (!$contact) {
            return back()->with('error_message', 'Cannot find contact information.');
        }
        $contact->metrics()->delete();
        $contact->favorites()->delete();
        $contact->outreaches()->delete();
        $contact->subrecords()->delete();
        $contact->recommendations()->delete();
        if ($contact['logo'] && file_exists(public_path($contact['logo']))) {
            unlink(public_path($contact['logo']));
        }
        $contact->delete();
        return back()->with('info_message', 'Contact information has been deleted.');
    }
}
