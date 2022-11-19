<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request) {
        $rule = [
            'email'     => ['required', 'email'],
            'password'  => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $message = '';
            $errors = $validator->errors()->messages();
            foreach ($errors as $error) {
                $message .= implode('<br>', $error).'<br>';
            }
            return response([
                'message' => $message,
            ], 400);
        }
        if (auth()->attempt($request->only(['email', 'password']))) {
            $user = auth()->user();
            $message = '';
            if (!$user['active'] || ($user['expires'] && $user['expires'] <= date('Y-m-d'))) {
                $contact_email = Setting::getSetting('contact_email', 'Extension@PubRecruiter.com');
                $message = 'Account Access Expired, Contact Us to Unlock<br>Email: <a href="mailto:'.$contact_email.'"><b>'.$contact_email.'</b></a>';
            } else if ($user['type'] == 'Brand' && $user['active'] == 2) {
                $message = 'Your Account is being processed.';
            } else if ($user['active'] == 3) {
                $message = 'Your Account has been blocked.';
            }
            if ($message) {
                return response([
                    'message' => $message
                ], 403);
            }
            $token = $user->createToken('LaravelSanctumAuth')->plainTextToken;
            return response([
                'success'       => true,
                'access_token'  => $token,
            ]);
        }
        return response([
            'message' => 'Credentials does not match.',
        ], 401);
    }

    /*public function register(Request $request) {
        $rule = [
            'email'     => ['required', 'email', 'unique:users'],
            'password'  => ['required', 'confirmed'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $message = '';
            foreach ($errors as $error) {
                $message .= implode('<br>', $error).'<br>';
            }
            return response([
                'message' => $message,
            ], 400);
        }
        $user = new User();
        $user['name']           = '';
        $user['email']          = $request['email'];
        $user['password']       = bcrypt($request['password']);
        $user['type']           = 'Creator';
        $user['ad_supported']   = 1;
        $user['active']         = 1;
        $user->save();
        if (auth()->attempt($request->only(['email', 'password']))) {
            $token = $user->createToken('LaravelSanctumAuth')->plainTextToken;
            return response([
                'success'       => true,
                'access_token'  => $token,
            ]);
        }
        return response([
            'message' => 'Credentials does not match.',
        ], 401);
    }*/
}
