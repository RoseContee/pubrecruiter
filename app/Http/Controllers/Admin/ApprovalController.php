<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BrandApproval;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class ApprovalController extends Controller
{
    private $menu = 'Approval';

    public function __construct()
    {
        View::share('menu', $this->menu);
    }

    public function index()
    {
        $today = date('Y-m-d');
        $users = User::brand()
            ->where(function($query) use ($today) {
                $query->where('active', 2)
                    ->orWhere('expires', '>=', $today);
            })
            ->get();
        return view('admin.approval.index', [
            'users' => $users,
        ]);
    }

    public function edit($id)
    {
        $today = date('Y-m-d');
        $user = User::brand()
            ->where(function($query) use ($today) {
                $query->where('active', 2)
                    ->orWhere('expires', '>=', $today);
            })
            ->where('id', $id)
            ->first();
        if (!$user) {
            return back()->with('error_message', 'Cannot find user information.');
        }
        return view('admin.approval.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $today = date('Y-m-d');
        $user = User::brand()
            ->where(function($query) use ($today) {
                $query->where('active', 2)
                    ->orWhere('expires', '>=', $today);
            })
            ->where('id', $id)
            ->first();
        if (!$user) {
            return back()->with('error_message', 'Cannot find user information.');
        }
        $rule = [
            'expires'   => ['required', 'date'],
        ];
        if ($request['paid_at']) {
            $rule['paid_at'] = ['date'];
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $user['paid_at']    = $request['paid_at'];
        $user['expires']    = $request['expires'];
        $user['active']     = 1;
        $user->save();
        $setting = Setting::getSetting(['site_name', 'site_logo']);
        try {
            $data = [
                'site_name' => $setting['site_name'],
                'site_logo' => $setting['site_logo'],
                'name'      => $user['name'],
            ];
            Mail::to($user['email'])->send(new BrandApproval($data));
        } catch(\Exception $exception) {
            //logger($exception->getMessage());
            //return back()->with('error_message', 'Sorry! Something went wrong. Please try again.');
        }
        return back()->with('info_message', 'User has been approved successfully.');
    }

    public function block(Request $request, $id)
    {
        $today = date('Y-m-d');
        $user = User::brand()
            ->where(function($query) use ($today) {
                $query->where('active', 2)
                    ->orWhere('expires', '>=', $today);
            })
            ->where('id', $id)
            ->first();
        if (!$user) {
            return back()->with('error_message', 'Cannot find user information.');
        }
        $user['active'] = 3;
        $user->save();
        return back()->with('error_message', 'User has been blocked.');
    }
}
