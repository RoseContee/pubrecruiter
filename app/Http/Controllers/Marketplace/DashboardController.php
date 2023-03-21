<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Mail\RecommendationPartnership;
use App\Mail\RequestPayout;
use App\Models\Contact;
use App\Models\Metric;
use App\Models\Opportunity;
use App\Models\Resource;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function getNoti() {
        $user = auth()->user();
        $outreaches = $user->partnerships()
            ->notSeen()
            ->orderBy('created_at', 'desc')
            ->get();
        $recommendations = $user->recommendations()
            ->notSeen()
            ->orderBy('created_at', 'desc')
            ->get();
        $i = $j = 0;
        $notis = [];
        while(!empty($outreaches[$i]) || !empty($recommendations[$j])) {
            if (!empty($outreaches[$i]) && !empty($recommendations[$j])) {
                if ($outreaches[$i]['created_at'] >= $recommendations[$j]['created_at']) $notis[] = $outreaches[$i++];
                else $notis[] = $recommendations[$j++];
            } else if (!empty($outreaches[$i])) $notis[] = $outreaches[$i++];
            else $notis[] = $recommendations[$j++];
        }
        return response()->json([
            'noti' => count($notis),
            'notis' => view('marketplace.partials.notifications.items', [
                'notis' => $notis
            ])->render(),
        ]);
    }

    public function seen(Request $request) {
        $ref = $request['ref'];
        $type = $request['type'];
        $user = auth()->user();
        if ($ref == 'all') {
            $user->partnerships()->update(['seen' => true]);
            $user->recommendations()->update(['seen' => true]);
        } else if ($type == 'outreach') {
            $user->partnerships()
                ->where(function ($query) use ($ref) {
                    if ($ref != 'all') $query->where('id', $ref);
                })
                ->update(['seen' => true]);
        } else {
            $user->recommendations()
                ->where(function ($query) use ($ref) {
                    if ($ref != 'all') $query->where('id', $ref);
                })
                ->update(['seen' => true]);
        }
        return response()->json([
            'success' => true,
        ]);
    }

    public function index(Request $request) {
        $user = auth()->user();
        $recommendation = $user->recommendations()->count();
        $opportunity = $user->opportunities()->where('expiry', '<', now())->count();
        $resource = Resource::type($user['type'])->count();
        $favorite = $user->favorites()
            ->whereHas('contact', function(Builder $query) use ($user) {
                $query->where(function($query) use ($user) {
                    $query->where('owner_id', '<>', $user['id'])
                        ->orWhere('owner_type', '<>', User::class);
                })->where('type', $user['type'] == 'Brand' ? 'Creator' : 'Brand');
            })
            ->count();
        $user_id = $user['id'];
        $tags = $user['contact']['tags'] ?? '';
        $tags = preg_split('/\s*,\s*/', $tags, -1, PREG_SPLIT_NO_EMPTY);
        $limit = 12;
        $all = $request['all'];
        $keyword = $request['q'];
        $n = $request['n'];
        $c = strtolower($request['c']);
        if ($user['type'] == 'Creator') {
            $contacts = Contact::with(['user'])
                ->has('user')
                ->notOwner($user_id)
                ->brand()
                ->active()
                ->where(function ($query) use ($keyword) {
                    if ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%")
                            ->orWhere('tags', 'like', "%{$keyword}%");
                    }
                })
                ->where(function ($query) use ($tags, $keyword, $all) {
                    if (!$keyword && !$all) {
                        foreach ($tags as $tag) {
                            $query->orWhere('tags', 'like', "%,{$tag},%");
                        }
                    }
                })
                ->where(function ($query) use ($n) {
                    if ($n) {
                        $query->where('network', $n);
                    }
                });
            if (in_array($c, ['asc', 'desc'])) {
                $contacts = $contacts->orderBy('commission', $c);
            }
            $contacts = $contacts->orderBy('featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate($limit)
                ->appends([
                    'q' => $keyword,
                    'c' => $c,
                    'n' => $n,
                ])
                ->withPath(route('more-contacts'));
            $networks = Contact::has('user')
                ->notOwner($user_id)
                ->brand()
                ->active()
                ->orderBy('network')
                ->groupBy('network')
                ->pluck('network')
                ->toArray();
        } else {
            $contacts = Contact::with(['user', 'user.opportunities', 'user.info', 'metric'])
                ->has('user')
                ->notOwner($user['id'])
                ->creator()
                ->active()
                ->where(function($query) use ($keyword) {
                    if ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%")
                            ->orWhere('tags', 'like', "%{$keyword}%");
                    }
                })
                ->where(function ($query) use ($tags, $keyword, $all) {
                    if (!$keyword && !$all) {
                        foreach ($tags as $tag) {
                            $query->orWhere('tags', 'like', "%,{$tag},%");
                        }
                    }
                })
                ->orderBy('featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate($limit)
                ->appends([
                    'q' => $keyword,
                ])
                ->withPath(route('more-contacts'));
        }
        $favorites = $user->favorites()->pluck('contact_id')->toArray();
        $sent = $user->outreaches()->pluck('contact_id')->toArray();
        return view('marketplace.dashboard.index', [
            'menu'          => 'Dashboard',
            'recommendation' => $recommendation,
            'opportunity'   => $opportunity,
            'resource'      => $resource,
            'favorite'      => $favorite,
            'keyword'       => $keyword,
            'c'             => $c,
            'n'             => $n,
            'contacts'      => $contacts,
            'networks'      => $networks ?? [],
            'favorites'     => $favorites,
            'sent'          => $sent,
        ]);
    }

    public function recommendation() {
        $user = auth()->user();
        $recommendations = $user->recommendations()
            ->has('contact')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('marketplace.dashboard.recommendation', [
            'menu' => 'Recommendation',
            'recommendations' => $recommendations,
        ]);
    }

    public function recommendationPartnership(Request $request) {
        $recommendation = auth()->user()
            ->recommendations()
            ->has('contact')
            ->where('id', $request['recommendation'])
            ->first();
        if (!$recommendation || empty($recommendation['contact']['email'])) {
            return response()->json([
                'success' => false,
            ], 404);
        }
        try {
            $email = $recommendation['contact']['email'];
            $setting = Setting::getSetting(['site_name', 'site_logo', 'partnership_email']);
            $data = [
                'site_name'     => $setting['site_name'],
                'site_logo'     => $setting['site_logo'],
                'from_email'    => $setting['partnership_email'],
            ];
            Mail::to($email)->send(new RecommendationPartnership($data));
        } catch (\Exception $exception) {
            //logger($exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Sorry! Something went wrong. Please try again.',
            ]);
        }
        return response()->json([
            'success' => true,
        ]);
    }

    public function inbound() {
        $user = auth()->user();
        $partnerships = $user->partnerships()
            ->with(['user'])
            ->has('user')
            ->orderBy('seen', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        if ($user['type'] != 'Brand') {
            foreach ($partnerships as $partnership) {
                if ($partnership['opportunities']) {
                    $partnership['opportunities'] = Opportunity::whereIn('id', explode(',', $partnership['opportunities']))
                        //->where('user_id', $partnership['owner_id'])
                        ->get();
                } else {
                    $partnership['opportunities'] = [];
                }
            }
        }
        return view('marketplace.dashboard.partnership', [
            'partnerships'  => $partnerships,
            'menu'          => 'Inbound',
        ]);
    }

    public function outbound() {
        $user = auth()->user();
        $outreaches = $user->outreaches()
            ->with(['contact', 'contact.user'])
            ->has('user')
            ->where(function ($query) {
                $query->where('manual', true)
                    ->orWhere(function ($q) {
                        $q->has('contact')
                            ->has('contact.user');
                    });
            })
            ->orderBy('seen', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        if ($user['type'] == 'Brand') {
            foreach ($outreaches as $outreach) {
                if ($outreach['opportunities']) {
                    $outreach['opportunities'] = Opportunity::whereIn('id', explode(',', $outreach['opportunities']))
                        //->where('user_id', $outreach['owner_id'])
                        ->get();
                } else {
                    $outreach['opportunities'] = [];
                }
            }
        }
        return view('marketplace.dashboard.partnership', [
            'partnerships'  => $outreaches,
            'menu'          => 'Outbound',
        ]);
    }

    public function updateOutbound(Request $request) {
        $user = auth()->user();
        if ($user['type'] != 'Brand') {
            return response()->json([
                'status' => 'Forbidden'
            ], 403);
        }
        $rule = [
            'io_date'   => ['nullable', 'date_format:Y-m-d'],
            'notes'     => ['nullable', 'max:75']
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }
        $outreach = $user->outreaches()->where('id', $request['partnership'])->first();
        if (!$outreach) {
            return response()->json([
                'status' => 'Forbidden'
            ], 403);
        }
        $outreach['payment_sent'] = !empty($request['payment_sent']);
        $outreach['io_date'] = $request['io_date'];
        $outreach['notes'] = $request['notes'];
        $outreach->save();
        return response()->json([
            'payment_sent'  => $outreach['payment_sent'],
            'io_date'       => $outreach['io_date'] ? date('n/j/y', strtotime($outreach['io_date'])) : '',
            'notes'         => $outreach['notes'],
        ]);
    }

    public function newOutreach() {
        return view('marketplace.dashboard.edit-outreach', [
            'menu' => 'Outbound',
        ]);
    }

    public function createOutreach(Request $request) {
        $user = auth()->user();
        $brand_user = $user['type'] == 'Brand';
        $rule = [
            'name' => ['required'],
            'email' => ['required', 'email'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user->outreaches()->create([
            'name'      => $request['name'],
            'email'     => $request['email'],
            'notes'     => $request['description'],
            'manual'    => true,
            'seen'      => true,
        ]);
        return redirect()->route('outbound')->with('success_message', 'New outreach created!');
    }

    public function editOutreach($id) {
        $user = auth()->user();
        $outreach = $user->outreaches()
            ->where('id', $id)
            ->where('manual', true)
            ->first();
        if (!$outreach) {
            return back()->with('error_message', 'Cannot find outreach information.');
        }
        return view('marketplace.dashboard.edit-outreach', [
            'menu'      => 'Outbound',
            'outreach'  => $outreach,
        ]);
    }

    public function updateOutreach(Request $request, $id) {
        $user = auth()->user();
        $outreach = $user->outreaches()
            ->where('id', $id)
            ->where('manual', true)
            ->first();
        if (!$outreach) {
            return back()->with('error_message', 'Cannot find outreach information.');
        }
        $rule = [
            'name' => ['required'],
            'email' => ['required', 'email'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $outreach['name'] = $request['name'];
        $outreach['email'] = $request['email'];
        $outreach['notes'] = $request['description'];
        $outreach->save();
        return back()->with('success_message', 'Outreach information updated!');
    }

    public function requestPayout(Request $request) {
        $user = auth()->user();
        if ($user['type'] != 'Creator') {
            return response()->json([
                'status' => 'Forbidden',
            ], 403);
        }
        $commission = $user->commissions()->where('paid', false)->sum('commission');
        if ($commission) {
            try {
                $setting = Setting::getSetting(['site_name', 'site_logo', 'partnership_email']);
                $data = [
                    'site_name'     => $setting['site_name'],
                    'site_logo'     => $setting['site_logo'],
                    'from_email'    => $setting['partnership_email'],
                    'name'          => $user['name'],
                    'email'         => $user['email'],
                    'commission'    => $commission,
                ];
                Mail::to($setting['partnership_email'])->send(new RequestPayout($data));
            } catch (\Exception $exception) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry! Something went wrong. Please try again.',
                ]);
            }
        }
        return response()->json([
            'success' => true,
        ]);
    }

    public function opportunities(Request $request) {
        $user = auth()->user();
        if ($user['type'] != 'Creator') {
            return redirect()->route('dashboard');
        }
        return view('marketplace.dashboard.opportunities', [
            'info'          => $user['info'],
            'opportunities' => $user['opportunities'],
            //'commissions'   => $user['commissions'],
            'menu'          => 'Opportunities',
        ]);
    }

    public function storeOpportunity(Request $request) {
        $user = auth()->user();
        if ($user['type'] != 'Creator') {
            return redirect()->route('dashboard');
        }
        if (count($user['opportunities']) >= 5) {
            return back()->with('error_message', 'You can add up to 5 opportunities.');
        }
        $rule = [
            'description'   => ['required', 'max:255'],
            'cost_type'     => ['required', 'in:dollar,Contact for Pricing'],
            'amount'        => ['required_if:cost_type,dollar'],
            'expiry'        => ['required', 'date'],
        ];
        if ($request['amount']) {
            $rule['amount'][] = 'numeric';
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator, 'opportunity');
        }
        $user->opportunities()->create([
            'description'   => $request['description'],
            'cost_type'     => $request['cost_type'],
            'cost'          => $request['cost_type'] == 'dollar' ? $request['amount'] : null,
            'expiry'        => $request['expiry'],
        ]);
        return back()->with('success_message', 'Opportunity has been added.');
    }

    public function updateOpportunity($id, Request $request) {
        $user = auth()->user();
        if ($user['type'] != 'Creator') {
            return redirect()->route('dashboard');
        }
        $opportunity = $user->opportunities()->where('id', $id)->first();
        if (!$opportunity) {
            return back()->with('error_message', 'Something went wrong.');
        }
        $rule = [
            'description'   => ['required', 'max:255'],
            'cost_type'     => ['required', 'in:dollar,Contact for Pricing'],
            'amount'        => ['required_if:cost_type,dollar'],
            'expiry'        => ['required', 'date'],
        ];
        if ($request['amount']) {
            $rule['amount'][] = 'numeric';
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->with('error_message', 'Something went wrong.');
        }
        $opportunity->update([
            'description'   => $request['description'],
            'cost_type'     => $request['cost_type'],
            'cost'          => $request['cost_type'] == 'dollar' ? $request['amount'] : null,
            'expiry'        => $request['expiry'],
        ]);
        return back()->with('info_message', 'Opportunity has been updated.');
    }

    public function destroyOpportunity($id) {
        $user = auth()->user();
        if ($user['type'] != 'Creator') {
            return redirect()->route('dashboard');
        }
        $opportunity = $user->opportunities()->where('id', $id)->first();
        if (!$opportunity) {
            return back()->with('error_message', 'Something went wrong.');
        }
        $opportunity->delete();
        return back()->with('info_message', 'Opportunity has been deleted.');
    }

    public function storeMediaKit(Request $request) {
        $user = auth()->user();
        if ($user['type'] != 'Creator') {
            return redirect()->route('dashboard');
        }
        $rule = [
            'description'   => ['nullable', 'max:50'],
            'link'          => ['required', 'url']
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator, 'media');
        }
        $user->info()->updateOrCreate([
            'user_id' => $user['id'],
        ], [
            'media_kit_link' => $request['link'],
            'media_kit_description' => $request['description'],
        ]);
        return back()->with('success_message', 'Media kit link has been updated.');
    }

    public function destroyMediaKit() {
        $user = auth()->user();
        $user = auth()->user();
        if ($user['type'] != 'Creator') {
            return redirect()->route('dashboard');
        }
        $user->info()->updateOrCreate([
            'user_id' => $user['id'],
        ], [
            'media_kit_link' => null,
            'media_kit_description' => null,
        ]);
        return back()->with('success_message', 'Media kit link has been removed.');
    }

    public function favorites() {
        $user = auth()->user();
        $favorites = $user->favorites()
            ->with(['contact', 'contact.user'])
            ->whereHas('contact', function(Builder $query) use ($user) {
                $query->where(function($query) use ($user) {
                    $query->where('owner_id', '<>', $user['id'])
                        ->orWhere('owner_type', '<>', User::class);
                })->where('type', $user['type'] == 'Brand' ? 'Creator' : 'Brand');
            })
            ->get();
        $sent = $user->outreaches()->pluck('contact_id')->toArray();
        return view('marketplace.dashboard.favorites', [
            'favorites' => $favorites,
            'sent'      => $sent,
            'menu'      => 'Favorite',
        ]);
    }

    public function removeFavorite(Request $request) {
        auth()->user()->favorites()->where('contact_id', $request['contact'])->delete();
        return response()->json([
            'success' => true,
        ]);
    }

    public function resource() {
        $user = auth()->user();
        $resources = Resource::type($user['type'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        return view('marketplace.dashboard.resources', [
            'menu' => 'Resource',
            'resources' => $resources,
        ]);
    }

    public function setting() {
        $user = auth()->user();
        if (!($contact = $user->contact)) {
            return redirect()->route('logout');
        }
        $metrics = $user_metrics = [];
        if ($user['type'] == 'Creator') {
            $metrics = Metric::get();
            $user_metrics = $contact->metrics()
                ->pluck('value', 'metric_id');
        }
        return view('marketplace.dashboard.setting', [
            'menu'          => 'Setting',
            'contact'       => $contact,
            'metrics'       => $metrics,
            'user_metrics'  => $user_metrics,
        ]);
    }

    public function updateSetting(Request $request) {
        $user = auth()->user();
        $metrics = Metric::get();
        $rule = [
            'type'              => ['required', 'in:profile,password,email'],

            'password'          => ['required_if:type,password', 'required_if:type,email'],
            'current_password'  => ['required_if:type,password', 'current_password'],
            'email'             => ['required_if:type,email'],
        ];
        if ($user['type'] == 'Creator') {
            foreach ($metrics as $metric) {
                if ($request['metric'.$metric['id']]) {
                    $rule['metric'.$metric['id']] = ['metric:'.strtolower($metric['type'])];
                }
            }
        }
        if ($request['type'] == 'password') {
            array_push($rule['password'], 'confirmed', 'min:6');
        } else if ($request['type'] == 'email') {
            $rule['email'][] = 'unique:users';
            $rule['password'][] = 'current_password';
        }
        $messages = [
            'password.required_if' => 'The password field is required.',
            'current_password.required_if' => 'The current password field is required.',
            'email.required_if' => 'The email field is required.',
        ];
        if (strtolower($request['email']) == strtolower($user['email'])) {
            $messages['email.unique'] = 'The email must be different from current email.';
        }
        $validator = Validator::make($request->all(), $rule, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if ($request['type'] == 'profile') {
            if ($contact = $user['contact']) {
                $contact['active'] = !empty($request['active']);
                $contact->save();

                if ($user['type'] == 'Creator') {
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
            } else {
                return redirect()->route('logout');
                //return back()->with('error_message', "Could not find your $user[type] information.");
            }
        } else if ($request['type'] == 'password') {
            $user['password'] = bcrypt($request['password']);
            $user->save();
        } else if ($request['type'] == 'email') {
            $user['email'] = $request['email'];
            $user->save();
        }
        return back()->withInput()->with('success_message', 'Successfully Updated!');
    }
}
