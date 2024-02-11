<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Favorite;
use App\Models\NoContact;
use App\Models\Opportunity;
use App\Models\Outreach;
use App\Models\ReferralCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    private $menu = 'Users';

    public function __construct()
    {
        View::share('menu', $this->menu);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()
            ->with(['info'])
            ->where('active', '<>', 2)
            ->get();
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $referrals = ReferralCode::query()->orderBy('code')->get();
        return view('admin.users.edit', [
            'referrals' => $referrals,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $rule = [
            'name'          => ['required'],
            'email'         => ['required', 'email', 'unique:users,email'],
            'type'          => ['required', 'in:Brand,Creator'],
            'ad_supported'  => ['required', 'in:0,1'],
            'active'        => ['required', 'in:0,1'],
            'password'      => ['required', 'confirmed', 'min:6'],
        ];
        if ($request['expires']) {
            $rule['expires'] = ['date'];
        }
        if ($request['referral_code']) {
            $rule['referral_code'] = ['exists:referral_codes,id'];
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $user                   = new User();
        $user['name']           = $request['name'];
        $user['email']          = $request['email'];
        $user['type']           = $request['type'];
        $user['expires']        = $request['expires'];
        $user['password']       = bcrypt($request['password']);
        $user['ad_supported']   = $request['ad_supported'];
        $user['active']         = $request['active'];
        $user->save();

        $user->info()->updateOrCreate([
            'user_id' => $user['id']
        ], [
            'referral_code_id' => $request['referral_code']
        ]);
        return redirect()->route('admin.users.index')->with('success_message', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $user = User::query()->find($id);
        if (!$user) {
            return back()->with('error_message', 'Cannot find user information.');
        }
        $referrals = ReferralCode::query()->orderBy('code')->get();
        return view('admin.users.edit', [
            'user'      => $user,
            'referrals' => $referrals,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $user = User::query()->find($id);
        if (!$user) {
            return back()->with('error_message', 'Cannot find user information.');
        }
        $rule = [
            'name'          => ['required'],
            'email'         => ['required', 'email', Rule::unique('users')->ignore($user['id'])],
            'type'          => ['required', 'in:Brand,Creator'],
            'ad_supported'  => ['required', 'in:0,1'],
            'active'        => ['required', 'in:0,1'],
        ];
        if ($request['expires']) {
            $rule['expires'] = ['date'];
        }
        if ($request['password'] || $request['password_confirmation']) {
            $rule['password'] = ['confirmed', 'min:6'];
        }
        if ($request['referral_code']) {
            $rule['referral_code'] = ['exists:referral_codes,id'];
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $old_type = $user['type'];

        $user['name']           = $request['name'];
        $user['email']          = $request['email'];
        $user['type']           = $request['type'];
        $user['expires']        = $request['expires'];
        $user['ad_supported']   = $request['ad_supported'];
        $user['active']         = $request['active'];
        if ($request['password']) {
            $user['password'] = bcrypt($request['password']);
        }
        $user->save();

        $user->info()->updateOrCreate([
            'user_id' => $user['id']
        ], [
            'referral_code_id' => $request['referral_code']
        ]);
        if ($old_type != $user['type']) {
            $user->contact()->update([
                'type' => $user['type'],
            ]);
        }
        return back()->with('info_message', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $user = User::query()->with(['contact'])->find($id);
        if (!$user) {
            return back()->with('error_message', 'Cannot find user information.');
        }
        if ($contact = $user['contact']) {
            $contact->metrics()->delete();
            Favorite::whose($user['id'])
                ->orWhere(function ($query) use ($contact) {
                    if ($contact) $query->where('contact_id', $contact['id']);
                })
                ->delete();
            Outreach::whose($user['id'])
                ->orWhere(function ($query) use ($contact) {
                    if ($contact) $query->where('contact_id', $contact['id']);
                })
                ->delete();
            $contact->delete();
        }
        $user->nocontacts()->delete();
        $user->opportunities()->delete();
        $user->subrecords()->delete();
        $user->info()->delete();
        $user->recommendations()->delete();
        $user->delete();
        return back()->with('info_message', 'User has been deleted.');
    }
}
