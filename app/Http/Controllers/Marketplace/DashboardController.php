<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Metric;
use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function getNoti() {
        $notis = auth()->user()
            ->partnerships()
            ->notSeen()
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json([
            'noti' => count($notis),
            'notis' => view('marketplace.partials.notifications.items', [
                'notis' => $notis
            ])->render(),
        ]);
    }

    public function seen(Request $request) {
        $ref = $request['ref'];
        auth()->user()->partnerships()
            ->where(function ($query) use ($ref) {
                if ($ref != 'all') $query->where('id', $ref);
            })
            ->update(['seen' => 1]);
        return response()->json([
            'success' => true,
        ]);
    }

    public function index() {
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
        return view('marketplace.dashboard.index', [
            'partnerships'  => $partnerships,
            'menu'          => 'Inbound',
        ]);
    }

    public function outbound() {
        $user = auth()->user();
        $outreaches = $user->outreaches()
            ->with(['contact', 'contact.user'])
            ->has('user')
            ->has('contact')
            ->has('contact.user')
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
        return view('marketplace.dashboard.index', [
            'partnerships'  => $outreaches,
            'menu'          => 'Outbound',
        ]);
    }

    public function updateOutbound(Request $request) {
        logger($request);
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
            'payment_sent' => $outreach['payment_sent'],
            'io_date' => $outreach['io_date'] ? date('n/j/y', strtotime($outreach['io_date'])) : '',
            'notes' => $outreach['notes'],
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
