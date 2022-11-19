<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function settings() {
        return view('admin.setting', [
            'menu' => 'Settings',
        ]);
    }

    public function updateSettings(Request $request) {
        $rule = [
            'site_name'         => ['required'],
            'site_url'          => ['required', 'url'],
            'contact_email'     => ['required', 'email'],
            'partnership_email' => ['required', 'email'],
            'extension_link'    => ['required', 'url'],
            'stripe_link'       => ['required', 'url'],
        ];
        if ($request->hasFile('site_logo')) {
            $rule['site_logo'] = ['image'];
        }
        if ($request->hasFile('favicon')) {
            $rule['favicon'] = ['image'];
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        Setting::saveSetting($request->only([
            'site_name', 'site_url', 'contact_email', 'partnership_email', 'extension_link', 'stripe_link',
        ]));
        $setting = Setting::getSetting(['site_logo', 'favicon']);
        if ($request->hasFile('site_logo')) {
            if ($setting['site_logo'] && file_exists(public_path($setting['site_logo']))) {
                unlink(public_path($setting['site_logo']));
            }
            $site_logo = 'uploads/'.$request->file('site_logo')->store('settings');
            Setting::saveSetting('site_logo', $site_logo);
        }
        if ($request->hasFile('favicon')) {
            if ($setting['favicon'] && file_exists(public_path($setting['favicon']))) {
                unlink(public_path($setting['favicon']));
            }
            $favicon = 'uploads/'.$request->file('favicon')->store('settings');
            Setting::saveSetting('favicon', $favicon);
        }
        return back()->with('success_message', 'Saved settings.');
    }

    public function profile() {
        return view('admin.profile', [
            'menu' => 'Profile',
        ]);
    }

    public function updateProfileEmail(Request $request) {
        $admin = auth('admin')->user();
        $rule = [
            'email'     => ['required', 'email', 'unique:admins'],
            'password'  => ['required'],
        ];
        $messages = [];
        if ($request['email'] == $admin['email']) {
            $messages['email.unique'] = 'Email cannot be same as current email.';
        }
        $validator = Validator::make($request->all(), $rule, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if (!Hash::check($request['password'], $admin['password'])) {
            return back()->withInput()->with('error_message', 'Password does not match current password.');
        }
        $admin['email'] = $request['email'];
        $admin->save();
        return back()->with('success_message', 'Your account email has been updated!');
    }

    public function updateProfilePassword(Request $request) {
        $admin = auth('admin')->user();
        $rule = [
            'old_password' => ['required'],
            'new_password' => ['required', 'confirmed'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if (!Hash::check($request['old_password'], $admin['password'])) {
            return back()->withInput()->with('error_message', 'Password does not match current password.');
        }
        $admin['password'] = bcrypt($request['new_password']);
        $admin->save();
        return back()->with('success_message', 'Your account password has been updated!');
    }
}
