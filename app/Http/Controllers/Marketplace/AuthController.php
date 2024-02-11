<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Mail\CreateUser;
use App\Mail\ForgotPassword;
use App\Mail\ResetPassword;
use App\Models\Admin;
use App\Models\Contact;
use App\Models\Network;
use App\Models\PasswordReset;
use App\Models\ReferralCode;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login() {
        return view('marketplace.auth.login');
    }

    public function postLogin(Request $request) {
        $rule = [
            'email'     => ['required', 'email'],
            'password'  => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if (auth()->attempt($request->only(['email', 'password']))) {
            $user = auth()->user();
            if (!$user['active'] || ($user['expires'] && $user['expires'] <= date('Y-m-d'))) {
                $contact_email = Setting::getSetting('contact_email', 'Extension@PubRecruiter.com');
                auth()->logout();
                return back()->withInput()
                    ->with('error_message', 'Account Access Expired.<br>Contact Us to Unlock<br>Email: <a href="mailto:' . $contact_email . '"><b>' . $contact_email . '</b></a>');
            } else if ($user['type'] == 'Brand' && $user['active'] == 2) {
                auth()->logout();
                return back()->withInput()->with('error_message', 'Your Account is being processed.');
            } else if ($user['active'] == 3) {
                auth()->logout();
                return back()->withInput()->with('error_message', 'Your Account has been blocked.');
            } else if (!$user['contact']) {
                $contact_email = Setting::getSetting('contact_email', 'Extension@PubRecruiter.com');
                auth()->logout();
                return back()->withInput()->with('error_message', 'Your account is not available.<br>Contact Us to Unlock<br>Email: <a href="mailto:' . $contact_email . '"><b>' . $contact_email . '</b></a>');
            }
            return redirect()->route('dashboard');
        }
        return back()->withInput()->with('error_message', 'Credentials does not match.');
    }

    public function createProfile() {
        return view('marketplace.auth.create-profile');
    }

    public function joinAsBrand() {
        $networks = Network::query()->get();
        return view('marketplace.auth.join-as-brand', [
            'networks' => $networks,
        ]);
    }

    public function postAsBrand(Request $request) {
        $rule = [
            'email'         => ['required', 'unique:users,email'],
            'password'      => ['required', 'confirmed'],
            'brand_name'    => ['required'],
            'brand_url'     => ['required', 'url'],
        ];
        if ($request['network']) {
            $rule['network'] = ['exists:networks,id'];
        } else {
            $rule['network_name'] = ['required'];
            $rule['network_link'] = ['required', 'url'];
        }
        if ($request->hasFile('logo')) {
            $rule['logo'] = ['required', 'image'];
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $website = $request['brand_url'];
        $domain = $request['domain'] = getDomain($website, $influencer);
        if ($influencer) {
            $validator->errors()->add('domain', 'The brand url field is invalid URL.');
            return back()->withErrors($validator)->withInput();
        }
        $rule = [
            'domain' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule, [
            'domain.required'   => 'The brand url field must be valid URL.',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $claim = $request['claim'];
        $contact = Contact::query()->where('domain', $domain)->first();
        $error = '';
        if ($contact) {
            if ($claim) {
                if ($contact['type'] != 'Brand' || $contact['owner_type'] != Admin::class) {
                    $error = 'This domain has already been taken.';
                }
            } else {
                $error = 'This domain has already been taken.';
                if ($contact['type'] == 'Brand' && $contact['owner_type'] == Admin::class) {
                    $error = 'We found your domain: <a href="javascript:void(0)" id="claim-profile" class="font-weight-bold">Claim your profile</a>';
                }
            }
        }
        if ($error) {
            $validator->errors()->add('domain', $error);
            return back()->withErrors($validator)->withInput();
        }
        $user = User::query()->create([
            'name'      => $request['brand_name'],
            'email'     => $request['email'],
            'password'  => bcrypt($request['password']),
            'type'      => 'Brand',
        ]);
        $referral = ReferralCode::query()->where('code', $request['refer'])->first();
        $user->info()->create([
            'referral_code_id' => $referral['id'] ?? null,
        ]);

        if ($claim) {
            $contact['owner_id'] = $user['id'];
            $contact['owner_type'] = User::class;
            $contact['email'] = $user['email'];
            $contact->save();
        } else {
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
            $user->contact()->create([
                'type'          => $user['type'],
                'name'          => $user['name'],
                'email'         => $user['email'],
                'website'       => $website,
                'domain'        => $domain,
                'logo'          => $logo ?? null,
                'network_id'    => $network_id,
                'network'       => $network,
                'network_link'  => $network_link,
                'active'        => 1,
            ]);
        }
        try {
            $setting = Setting::getSetting(['site_name', 'site_logo', 'contact_email', 'extension_link']);
            $data = [
                'user_type'     => $user['type'],
                'site_name'     => $setting['site_name'],
                'site_logo'     => $setting['site_logo'],
                'from_email'    => $setting['contact_email'],
                'extension_link' => $setting['extension_link'],
            ];
            Mail::to($user['email'])->send(new CreateUser($data));
        } catch(\Exception $exception) {
            //logger($exception->getMessage());
        }
        if (auth()->attempt($request->only(['email', 'password']))) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('login')->with('error_message', 'Credentials does not match.');
    }

    public function joinAsCreator() {
        return view('marketplace.auth.join-as-creator');
    }

    public function postAsCreator(Request $request) {
        $rule = [
            'email'         => ['required', 'unique:users,email'],
            'password'      => ['required', 'confirmed'],
            'website_name'  => ['required'],
            'website'       => ['required', 'url'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $website = $request['website'];
        $domain = $request['domain'] = getDomain($website, $influencer);
        $rule = [
            'domain' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule, [
            'domain.required'   => $influencer ? 'Social media URL must be valid URL.' : 'The website field must be valid URL.',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $claim = $request['claim'];
        $contact = Contact::query()->where('domain', $domain)->first();
        $error = '';
        if ($contact) {
            if ($claim) {
                if ($contact['type'] != 'Creator' || $contact['owner_type'] != Admin::class) {
                    $error = 'This domain has already been taken.';
                }
            } else {
                $error = 'This domain has already been taken.';
                if ($contact['type'] == 'Creator' && $contact['owner_type'] == Admin::class) {
                    $error = 'We found your domain: <a href="javascript:void(0)" id="claim-profile" class="font-weight-bold">Claim your profile</a>';
                }
            }
        }
        if ($error) {
            $validator->errors()->add('domain', $error);
            return back()->withErrors($validator)->withInput();
        }
        $user = User::query()->create([
            'name'      => $claim ? $contact['name'] : $request['website_name'],
            'email'     => $request['email'],
            'password'  => bcrypt($request['password']),
            'type'      => 'Creator',
        ]);
        $referral = ReferralCode::query()->where('code', $request['refer'])->first();
        $user->info()->create([
            'referral_code_id' => $referral['id'] ?? null,
        ]);
        if ($claim) {
            $contact['owner_id'] = $user['id'];
            $contact['owner_type'] = User::class;
            $contact['email'] = $user['email'];
            $contact->save();
        } else {
            $user->contact()->create([
                'type'      => $user['type'],
                'name'      => $user['name'],
                'email'     => $user['email'],
                'website'   => $website,
                'domain'    => $domain,
                'offers'    => !empty($request['offers']),
                'posts'     => !empty($request['posts']),
                'active'    => !empty($request['active']),
            ]);
        }
        try {
            $setting = Setting::getSetting(['site_name', 'site_logo', 'contact_email']);
            $data = [
                'user_type'     => $user['type'],
                'site_name'     => $setting['site_name'],
                'site_logo'     => $setting['site_logo'],
                'from_email'    => $setting['contact_email'],
            ];
            Mail::to($user['email'])->send(new CreateUser($data));
        } catch(\Exception $exception) {
            //logger($exception->getMessage());
        }
        if (auth()->attempt($request->only(['email', 'password']))) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('login')->with('error_message', 'Credentials does not match.');
    }

    public function forgot() {
        return view('marketplace.auth.forgot-password');
    }

    public function postForgot(Request $request) {
        $rule = [
            'email' => ['required', 'email', 'exists:users,email'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $email = $request['email'];
        $token = Str::random(32);
        $now = now();
        $password_reset = PasswordReset::firstOrCreate([
            'type'          => 'user',
            'email'         => $email,
        ], [
            'token'         => $token,
            'created_at'    => $now,
        ]);
        if (!$password_reset['token'] || $now->diffInSeconds(new Carbon($password_reset['created_at'])) > 15 * 60) {
            $password_reset['token']        = $token;
            $password_reset['created_at']   = $now;
            $password_reset->save();
        }
        $token = $password_reset['token'];
        try {
            $setting = Setting::getSetting(['site_name', 'site_logo']);
            $data = [
                'site_name' => $setting['site_name'],
                'site_logo' => $setting['site_logo'],
                'email'     => $email,
                'link'      => route('reset-password', $token),
            ];
            Mail::to($email)->send(new ForgotPassword($data));
        } catch(\Exception $exception) {
            //return back()->withInput()->with('error_message', $exception->getMessage());
            return back()->withInput()->with('error_message', 'Sorry! Something went wrong. Please try again.');
        }
        return back()->with('info_message', 'We sent rest link to your email. If you did not receive, please try again.');
    }

    public function reset($token) {
        $password_reset = PasswordReset::type('user')->where('token', $token)->first();
        if (!$password_reset) {
            return view('marketplace.auth.not-found', [
                'error_message' => 'Your reset request is invalid. Please check your inbox again.',
            ]);
        }
        if (now()->diffInSeconds(new Carbon($password_reset['created_at'])) > 15 * 60) {
            $password_reset['token'] = null;
            $password_reset->save();
            return view('marketplace.auth.not-found', [
                'error_message' => 'This reset link is already expired. Please try again.',
            ]);
        }
        $user = User::query()->where('email', $password_reset['email'])->first();
        if (!$user) {
            $password_reset->delete();
            return view('marketplace.auth.not-found', [
                'error_message' => 'Your reset request is invalid. Your account does not exist anymore.',
            ]);
        }
        return view('marketplace.auth.reset-password');
    }

    public function postReset($token, Request $request) {
        $password_reset = PasswordReset::type('user')->where('token', $token)->first();
        if (!$password_reset) {
            return back()->with('error_message', 'Your reset request is invalid. Please check your inbox again.');
        }
        if (now()->diffInSeconds(new Carbon($password_reset['created_at'])) > 15 * 60) {
            $password_reset['token'] = null;
            $password_reset->save();
            return back()->with('error_message', 'This reset link is already expired. Please try again.');
        }
        $user = User::query()->where('email', $password_reset['email'])->first();
        if (!$user) {
            $password_reset->delete();
            return back()->with('error_message', 'Your reset request is invalid. Your account does not exist anymore.');
        }
        $rule = [
            'password' => ['required', 'confirmed'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $user['password'] = bcrypt($request['password']);
        $user->save();
        $email = $user['email'];
        try {
            $setting = Setting::getSetting(['site_name', 'site_logo', 'contact_email']);
            $data = [
                'site_name'     => $setting['site_name'],
                'site_logo'     => $setting['site_logo'],
                'email'         => $email,
                'contact_email' => $setting['contact_email'],
            ];
            Mail::to($email)->send(new ResetPassword($data));
        } catch(\Exception $exception) {
            //return back()->withInput()->with('error_message', $exception->getMessage());
            return back()->withInput()->with('error_message', 'Sorry! Something went wrong. Please try again.');
        }
        $password_reset['token'] = null;
        $password_reset->save();
        return view('marketplace.auth.not-found')->with('info_message', 'Your password has been reset successfully.');
    }
}
