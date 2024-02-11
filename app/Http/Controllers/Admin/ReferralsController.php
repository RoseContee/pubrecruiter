<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferralCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class ReferralsController extends Controller
{
    private $menu = 'Referrals';

    public function __construct()
    {
        View::share('menu', $this->menu);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $referrals = ReferralCode::query()->get();
        return view('admin.referrals.index', [
            'referrals' => $referrals,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.referrals.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rule = [
            'code' => ['required', 'unique:referral_codes,code'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $referral         = new ReferralCode();
        $referral['code'] = $request['code'];
        $referral->save();
        return redirect()->route('admin.referrals.index')->with('success_message', 'Referral code created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $referral = ReferralCode::query()->find($id);
        if (!$referral) {
            return back()->with('error_message', 'Cannot find referral code information.');
        }
        return view('admin.referrals.edit', [
            'referral'   => $referral,
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
        $referral = ReferralCode::query()->find($id);
        if (!$referral) {
            return back()->with('error_message', 'Cannot find referral code information.');
        }
        $rule = [
            'code' => ['required', Rule::unique('referral_codes', 'code')->ignore($referral['id'])],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $referral['code'] = $request['code'];
        $referral->save();
        return back()->with('success_message', 'Referral code updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $referral = ReferralCode::query()->find($id);
        if (!$referral) {
            return back()->with('error_message', 'Cannot find referral information.');
        }
        $referral->delete();
        return back()->with('info_message', 'Referral has been deleted.');
    }
}
