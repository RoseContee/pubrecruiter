<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\NoContactFound;
use App\Mail\PartnershipInquiry;
use App\Mail\RequestPublisher;
use App\Models\ADS;
use App\Models\Blacklist;
use App\Models\Contact;
use App\Models\Favorite;
use App\Models\Feedback;
use App\Models\Network;
use App\Models\NoContact;
use App\Models\Opportunity;
use App\Models\Outreach;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function contact(Request $request)
    {
        if (!($domain = $request['domain'])) return response()->json([], 500);
        $user = auth()->user();
        $user_id = $user['id'];
        $contact_email = Setting::getSetting('contact_email', 'Extension@PubRecruiter.com');
        $blacklist = $contact = $nocontact = false;
        if (!($blacklist = !empty(Blacklist::domain($domain)->first()))) {
            $item = Contact::with(['user', 'user.opportunities'])
                ->has('user')
                ->notOwner($user_id)
                ->userType($user['type'])
                ->domain($domain)
                ->first();
            if ($item) {
                $commission = $affiliate_link = '';
                if ($item['type'] == 'Brand') {
                    if ($item['commission']) {
                        $commission .= $item['commission_type'] == '$' ? '$' : '';
                        $commission .= $item['commission'];
                        $commission .= $item['commission_type'] == '%' ? '%' : '';
                        $commission .= ' '.$item['commission_unit'];
                    }
                    $affiliate_link = route('mask', ['code' => $item['code'], 't' => $user_id]);
                }
                $opportunities = [];
                if ($item['type'] == 'Creator') {
                    foreach ($item['user']['opportunities'] as $opportunity) {
                        $opportunities[] = [
                            'ref'           => $opportunity['id'],
                            'description'   => $opportunity['description'],
                            'cost_type'     => $opportunity['cost_type'],
                            'cost'          => $opportunity['cost'],
                        ];
                    }
                }
                $inquiry = !empty($user->outreaches()
                    ->whereHas('contact', function (Builder $query) use ($domain) {
                        $query->where('domain', $domain);
                    })
                    ->first());
                $favorite = !empty($user->favorites()->where('contact_id', $item['id'])->first());
                $feedback = false;
                $response_time = $number = 0;
                $feedbacks = Feedback::domain($domain)->get();
                foreach ($feedbacks as $f) {
                    if ($f['response_time'] >= 1) {
                        $response_time += $f['response_time'];
                        $number++;
                    }
                    if ($f['user_id'] == $user_id) $feedback = true;
                }
                if ($number) $response_time = ceil($response_time / $number);
                $contact = [
                    'category'      => ucfirst($item['type']),
                    'name'          => $item->contact_name(),
                    'email'         => $item->contact_email(),
                    'network'       => $item['type'] == 'Brand' ? $item['network'] : null,
                    'network_link'  => $item['type'] == 'Brand' ? $item['network_link'] : null,
                    'commission'    => $commission,
                    'opportunities' => json_encode($opportunities),
                    'inquiry'       => $inquiry,
                    'favorite'      => $favorite,
                    'affiliate_link' => $affiliate_link,
                    'response_time' => $response_time,
                    'feedback'      => $feedback,
                ];
            } else {
                $nocontact = !empty($user->nocontacts()->where('domain', $domain)->first());
            }
        }
        return response()->json([
            'success' => true,
            'details' => [
                'contact_email' => $contact_email,
                'blacklist'     => $blacklist,
                'contact'       => $contact,
                'nocontact'     => $nocontact,
            ]
        ]);
    }

    public function notifications()
    {
        $user = auth()->user();
        $notifications = [];
        $partnerships = $user->partnerships()
            ->with('user')
            ->notSeen()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        foreach ($partnerships as $partnership) {
            $notifications[] = [
                'id'            => $partnership['id'],
                'opportunity'   => !empty($partnership['opportunities']),
                'user'          => $partnership['user']['name'] ?? 'Someone',
            ];
        }
        $ad = null;
        if ($user['ad_supported'] && ($ad = ADS::active()->first())
            && $ad['image'] && file_exists(public_path($ad['image'])) && $ad['link'])
        {
            $ad = [
                'image' => asset('public/'.$ad['image']),
                'link'  => $ad['link'],
            ];
        }
        return response()->json([
            'success' => true,
            'details' => [
                'notifications' => $notifications,
                'ad'            => $ad,
            ],
        ]);
    }

    public function noContactFound(Request $request)
    {
        if (!($domain = getDomain($request['domain']))) return response()->json([], 500);
        $user = auth()->user();
        if (!($user->nocontacts()->where('domain', $domain)->first())) {
            try {
                $setting = Setting::getSetting(['site_name', 'site_logo', 'contact_email']);
                $data = [
                    'site_name'     => $setting['site_name'],
                    'site_logo'     => $setting['site_logo'],
                    'from_email'    => $setting['contact_email'],
                    'email'         => $user['email'],
                    'website'       => $domain,
                ];
                Mail::to($setting['contact_email'])->send(new NoContactFound($data));

                $user->nocontacts()->create([
                    'domain' => $domain
                ]);
            } catch(\Exception $exception) {
                return response()->json([
                    'message' => 'Sorry! Something went wrong. Please try again.',
                ], 422);
            }
        }
        return response()->json([
            'success' => true,
        ]);
    }

    public function addFavorite(Request $request)
    {
        if (!($domain = $request['domain'])) return response()->json([], 500);
        $user = auth()->user();
        $user_id = $user['id'];
        $user_type = $user['type'];
        $contact = Contact::has('user')
            ->notOwner($user_id)
            ->userType($user_type)
            ->domain($domain)
            ->first();
        if (!$contact) {
            return response()->json([
                'success' => false,
            ], 404);
        }
        $favorite = $user->favorites()->where('contact_id', $contact['id'])->first();
        if ($favorite) {
            $favorite->delete();
            $favorite = false;
        } else {
            $user->favorites()->create([
                'contact_id' => $contact['id'],
            ]);
            $favorite = true;
        }
        return response()->json([
            'success' => true,
            'details' => [
                'favorite' => $favorite
            ]
        ]);
    }

    public function sendPartnershipInquiry(Request $request)
    {
        if (!($domain = $request['domain'])) return response()->json([], 500);
        $user = auth()->user();
        $user_id = $user['id'];
        $user_type = $user['type'];
        $contact = Contact::with(['user'])
            ->has('user')
            ->notOwner($user_id)
            ->userType($user_type)
            ->domain($domain)
            ->first();
        if (!$contact) {
            return response()->json([
                'success' => false,
            ], 404);
        }
        $sent = $user->outreaches()
            ->where('contact_id', $contact['id'])
            ->first();
        if (!$sent) {
            try {
                $offers = $contact['offers'] ? 'Affiliate Offers' : '';
                $posts  = $contact['posts'] ? 'Sponsored Posts' : '';
                $setting = Setting::getSetting(['site_name', 'site_logo', 'partnership_email']);
                $data = [
                    'user_type'     => $user_type,
                    'site_name'     => $setting['site_name'],
                    'site_logo'     => $setting['site_logo'],
                    'from_email'    => $setting['partnership_email'],
                    'name'          => $user['name'],
                    'email'         => $user['email'],
                    'offers'        => $offers,
                    'posts'         => $posts,
                ];
                Mail::to($contact->contact_email())->send(new PartnershipInquiry($data));

                $user->outreaches()->create([
                    'contact_id' => $contact['id'],
                    'owner_id'   => $contact['owner_id'],
                    'owner_type' => $contact['owner_type'],
                ]);
            } catch(\Exception $exception) {
                //logger($exception->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry! Something went wrong. Please try again.',
                ], 422);
            }
        }
        return response()->json([
            'success' => true,
        ]);
    }

    public function sendOpportunitiesInquiry(Request $request)
    {
        if (!($domain = $request['domain'])) return response()->json([], 500);
        $user = auth()->user();
        $user_id = $user['id'];
        $user_type = $user['type'];
        $contact = Contact::with(['user'])
            ->has('user')
            ->notOwner($user_id)
            ->userType($user_type)
            ->domain($domain)
            ->first();
        if (!$contact) {
            return response()->json([
                'success' => false,
            ], 404);
        }
        $rule = [
            'opportunities' => ['required', 'array'],
        ];
        $validator = Validator::make($request->all(), $rule, [
            'opportunities.required' => 'Please select an opportunity.',
            'opportunities.array'    => 'Please select an opportunity.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->getMessages(),
            ], 400);
        }
        if (!count($opportunityIds = $request['opportunities'])) {
            return response()->json([
                'success' => false,
            ], 404);
        }
        $creator = null;
        $opportunities = Opportunity::where('user_id', '<>', $user['id'])
            ->whereIn('id', $opportunityIds)
            ->get();
        foreach ($opportunities as $opportunity) {
            if (($creator['id'] ?? null) != $opportunity['user_id']) {
                if ($creator) {
                    return response()->json([
                        'success' => false,
                    ], 404);
                }
                $creator = $opportunity['user'];
            }
        }
        if (count($opportunities) != count($opportunityIds)) {
            return response()->json([
                'success' => false,
            ], 404);
        }
        try {
            $setting = Setting::getSetting(['site_name', 'site_logo', 'partnership_email']);
            $data = [
                'user_type'     => 'Opportunity',
                'site_name'     => $setting['site_name'],
                'site_logo'     => $setting['site_logo'],
                'from_email'    => $setting['partnership_email'],
                'name'          => $user['name'],
                'email'         => $user['email'],
                'creator'       => $contact->contact_name(),
                'opportunities' => $opportunities,
            ];
            Mail::to($contact->contact_email())->send(new PartnershipInquiry($data));

            $user->outreaches()->create([
                'contact_id'    => $contact['id'],
                'owner_id'      => $contact['owner_id'],
                'owner_type'    => $contact['owner_type'],
                'opportunities' => implode(',', $opportunityIds),
            ]);
        } catch(\Exception $exception) {
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

    public function saveFeedback(Request $request)
    {
        if (!($domain = getDomain($request['domain']))) return response()->json([], 500);
        $user = auth()->user();
        if ($user->feedbacks()->where('domain', $domain)->first()) {
            return response()->json([
                'message' => 'You have already submitted feedback on this site.',
            ], 403);
        }
        $response_time = $request['response_time'];
        $response_time = in_array($response_time, [1, 2, 3, 4]) ? $response_time : null;
        $user->feedbacks()->create([
            'domain'        => $domain,
            'response_time' => $response_time,
            'comment'       => $request['comment'],
        ]);
        return response()->json([
            'success' => true,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $rule = [
            'current_password'  => ['required'],
            'password'          => ['required', 'confirmed'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $message = '';
            $errors = $validator->errors()->messages();
            foreach ($errors as $error) {
                $message .= implode('<br>', $error).'<br>';
            }
            return response()->json([
                'message' => $message,
            ], 400);
        }
        $user = auth()->user();
        if (!Hash::check($request['current_password'], $user['password'])) {
            return response()->json([
                'message' => 'Current password is not correct.',
            ], 403);
        }
        $user['password'] = bcrypt($request['password']);
        $user->save();
        return response()->json([
            'success' => true,
        ]);
    }

    public function requestPublisher(Request $request)
    {
        $rule = [
            'message' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $message = '';
            $errors = $validator->errors()->messages();
            foreach ($errors as $error) {
                $message .= implode('<br>', $error).'<br>';
            }
            return response()->json([
                'message' => $message,
            ], 400);
        }
        $user = auth()->user();
        try {
            $setting = Setting::getSetting(['site_name', 'site_logo', 'contact_email']);
            $data = [
                'site_name' => $setting['site_name'],
                'site_logo' => $setting['site_logo'],
                'email'     => $user['email'],
                'message'   => $request['message'],
            ];
            Mail::to($setting['contact_email'])->send(new RequestPublisher($data));
        } catch(\Exception $exception) {
            return response()->json([
                'message' => 'Sorry! Something went wrong. Please try again.',
            ], 422);
        }
        return response()->json([
            'success' => true,
        ]);
    }

    public function clearNoti(Request $request)
    {
        auth()->user()->partnerships()
            ->where('id', $request['noti'])
            ->update(['seen' => 1]);
        return response()->json([
            'success' => true,
        ]);
    }
}
