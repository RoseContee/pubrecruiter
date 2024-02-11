<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Mail\PartnershipInquiry;
use App\Models\Contact;
use App\Models\Network;
use App\Models\Opportunity;
use App\Models\Setting;
use App\Models\SubRecord;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index() {
        $user = auth()->user();
        $user_id = $user['id'] ?? null;
        $tags = $user['contact']['tags'] ?? '';
        $tags = preg_split('/\s*,\s*/', $tags, -1, PREG_SPLIT_NO_EMPTY);
        $limit = $user ? 8 : 4;
        if (!$user || $user['type'] == 'Creator') {
            $contacts['brands'] = Contact::query()
                ->with(['user'])
                ->has('user')
                ->notOwner($user_id)
                ->brand()
                ->active()
                ->where(function ($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->orWhere('tags', 'like', "%,{$tag},%");
                    }
                })
                ->orderBy('featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
            $networks = Contact::has('user')
                ->notOwner($user_id)
                ->brand()
                ->active()
                ->orderBy('network')
                ->groupBy('network')
                ->pluck('network')
                ->toArray();
        }
        if (!$user || $user['type'] == 'Brand') {
            $contacts['creators'] = Contact::query()
                ->with(['user', 'user.opportunities', 'user.info', 'metric'])
                ->has('user')
                ->notOwner($user_id)
                ->creator()
                ->active()
                ->where(function ($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->orWhere('tags', 'like', "%,{$tag},%");
                    }
                })
                ->orderBy('featured', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        }
        if ($user) {
            $favorites = $user->favorites()->pluck('contact_id')->toArray();
            $sent = $user->outreaches()->pluck('contact_id')->toArray();
        }
        return view('marketplace.index', [
            'contacts'  => $contacts,
            'networks'  => $networks ?? [],
            'favorites' => $favorites ?? [],
            'sent'      => $sent ?? [],
        ]);
    }

    public function brands(Request $request) {
        $user = auth()->user();
        if ($user['type'] == 'Brand') {
            return redirect()->route('creators');
        }
        $user_id = $user['id'];
        $tags = $user['contact']['tags'] ?? '';
        $tags = preg_split('/\s*,\s*/', $tags, -1, PREG_SPLIT_NO_EMPTY);
        $all = $request['all'];
        $keyword = $request['q'];
        $n = $request['n'];
        $c = strtolower($request['c']);
        $limit = 12;
        $contacts = Contact::query()
            ->with(['user'])
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
                'q'   => $keyword,
                'c'   => $c,
                'n'   => $n,
                'all' => $all,
            ])
            ->withPath(route('more-contacts'));
        $favorites = $user->favorites()->pluck('contact_id')->toArray();
        $sent = $user->outreaches()->pluck('contact_id')->toArray();
        $networks = Contact::query()
            ->has('user')
            ->notOwner($user_id)
            ->brand()
            ->active()
            ->orderBy('network')
            ->groupBy('network')
            ->pluck('network')
            ->toArray();
        return view('marketplace.search', [
            'keyword'   => $keyword,
            'c'         => $c,
            'n'         => $n,
            'contacts'  => $contacts,
            'favorites' => $favorites,
            'sent'      => $sent,
            'networks'  => $networks,
        ]);
    }

    public function creators(Request $request) {
        $user = auth()->user();
        if ($user['type'] == 'Creator') {
            return redirect()->route('brands');
        }
        $tags = $user['contact']['tags'] ?? '';
        $tags = preg_split('/\s*,\s*/', $tags, -1, PREG_SPLIT_NO_EMPTY);
        $all = $request['all'];
        $keyword = $request['q'];
        $limit = 12;
        $contacts = Contact::query()
            ->with(['user', 'user.opportunities', 'user.info', 'metric'])
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
                'q'   => $keyword,
                'all' => $all,
            ])
            ->withPath(route('more-contacts'));
        $favorites = $user->favorites()->pluck('contact_id')->toArray();
        $sent = $user->outreaches()->pluck('contact_id')->toArray();
        return view('marketplace.search', [
            'keyword'   => $keyword,
            'contacts'  => $contacts,
            'favorites' => $favorites,
            'sent'      => $sent,
        ]);
    }

    public function moreContacts(Request $request) {
        $user = auth()->user();
        $tags = $user['contact']['tags'] ?? '';
        $tags = preg_split('/\s*,\s*/', $tags, -1, PREG_SPLIT_NO_EMPTY);
        $all = $request['all'];
        $keyword = $request['q'];
        $limit = 12;
        $contacts = Contact::query()
            ->with(['user'])
            ->has('user')
            ->notOwner($user['id'])
            ->userType($user['type'])
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
            });
        $query = [
            'q'   => $keyword,
            'all' => $all,
        ];
        if ($user['type'] == 'Creator') {
            $query['n'] = $n = $request['n'];
            $query['c'] = $c = strtolower($request['c']);
            if ($n) {
                $contacts = $contacts->where('network', $n);
            }
            if (in_array($c, ['asc', 'desc'])) {
                $contacts = $contacts->orderBy('commission', $c);
            }
        } else {
            $contacts = $contacts->with(['user.opportunities', 'user.info', 'metric']);
        }
        $contacts = $contacts->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($limit)
            ->appends($query)
            ->withPath(route('more-contacts'));
        $favorites = $user->favorites()->pluck('contact_id')->toArray();
        $sent = $user->outreaches()->pluck('contact_id')->toArray();
        $contacts_list = '';
        foreach ($contacts as $contact) {
            $contacts_list .= view('marketplace.partials.contact.item', [
                'contact'   => $contact,
                'favorites' => $favorites,
                'sent'      => $sent,
            ])->render();
        }
        return response()->json([
            'contacts'  => $contacts_list,
            'next'      => $contacts->nextPageUrl()
        ]);
    }

    public function favoriteBrand(Request $request) {
        $user = auth()->user();
        $contact = Contact::notOwner($user['id'])
            ->where('id', $request['contact'])
            ->userType($user['type'])
            ->first();
        if (!$contact) {
            return response()->json([
                'success' => false,
            ], 404);
        }
        $favorites = $user->favorites()
            ->where('contact_id', $contact['id'])
            ->get();
        if (count($favorites)) {
            $user->favorites()
                ->where('contact_id', $contact['id'])
                ->delete();
            $status = 0;
        } else {
            $user->favorites()->create([
                'contact_id' => $contact['id'],
            ]);
            $status = 1;
        }
        return response()->json([
            'success'   => true,
            'status'    => $status,
        ]);
    }

    public function requestPartnership(Request $request) {
        $user = auth()->user();
        $contact = Contact::query()
            ->with(['user'])
            ->has('user')
            ->where('id', $request['contact'])
            ->notOwner($user['id'])
            ->userType($user['type'])
            ->active()
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
                    'user_type'     => $user['type'],
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
                ]);
            }
        }
        return response()->json([
            'success' => true,
        ]);
    }

    public function opportunitiesInquiry(Request $request) {
        $user = auth()->user();
        if ($user['type'] != 'Brand') {
            return response()->json([
                'success' => false,
            ], 403);
        }
        $contact = Contact::query()
            ->with(['user'])
            ->has('user')
            ->where('id', $request['contact'])
            ->notOwner($user['id'])
            ->userType($user['type'])
            ->active()
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
        $opportunities = Opportunity::query()
            ->where('user_id', '<>', $user['id'])
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

    public function trackNetworkSignup(Request $request) {
        $user = auth()->user();
        if ($user['type'] != 'Creator') {
            return response()->json([
                'success' => false,
            ], 403);
        }
        $contact = Contact::query()
            ->has('user')
            ->where('id', $request['contact'])
            ->notOwner($user['id'])
            ->userType($user['type'])
            ->active()
            ->first();
        if (!$contact) {
            return response()->json([
                'success' => false,
            ], 404);
        }
        SubRecord::query()->create([
            'user_id'       => $user['id'],
            'contact_id'    => $contact['id'],
        ]);
        return response([
            'success' => true,
        ]);
    }
}
