<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class RecommendationsController extends Controller
{
    private $menu = 'Recommendations';

    public function __construct()
    {
        View::share('menu', $this->menu);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recommendations = Recommendation::orderBy('created_at', 'desc')->get();
        return view('admin.recommendations.index', [
            'recommendations' => $recommendations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $contacts = Contact::orderBy('name')->get();
        return view('admin.recommendations.edit', [
            'users'    => $users,
            'contacts' => $contacts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rule = [
            'user'           => ['required', 'exists:users,id'],
            'recommendation' => ['required', 'exists:contacts,id'],
            'email'          => ['required', 'email'],
            'response_time'  => ['required', 'in:1,2,3,4'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $selected_user = User::find($user = $request['user']);
        $selected_recommend = Contact::find($recommend = $request['recommendation']);
        if ($selected_user['type'] == $selected_recommend['type']) {
            $validator->errors()->add('recommendation', 'The recommendation should not be same with the user.');
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        if (Recommendation::where('user_id', $user)
            ->where('contact_id', $recommend)
            ->exists()
        ) {
            $validator->errors()->add('recommendation', 'The same recommendation already attached to the user.');
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $recommendation                  = new Recommendation();
        $recommendation['user_id']       = $user;
        $recommendation['contact_id']    = $recommend;
        $recommendation['email']         = $request['email'];
        $recommendation['note']          = $request['note'];
        $recommendation['response_time'] = $request['response_time'];
        $recommendation->save();
        return redirect()->route('admin.recommendations.index')->with('success_message', 'New recommendation created!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $recommendation = Recommendation::find($id);
        if (!$recommendation) {
            return back()->with('error_message', 'Cannot find recommendation information.');
        }
        $users = User::orderBy('name')->get();
        $contacts = Contact::orderBy('name')->get();
        return view('admin.recommendations.edit', [
            'recommendation' => $recommendation,
            'users'          => $users,
            'contacts'       => $contacts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $recommendation = Recommendation::find($id);
        if (!$recommendation) {
            return back()->with('error_message', 'Cannot find recommendation information.');
        }
        $rule = [
            'email'         => ['required', 'email'],
            'response_time' => ['required', 'in:1,2,3,4'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $recommendation['email']         = $request['email'];
        $recommendation['note']          = $request['note'];
        $recommendation['response_time'] = $request['response_time'];
        $recommendation->save();
        return back()->with('success_message', 'Recommendation updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $recommendation = Recommendation::find($id);
        if (!$recommendation) {
            return back()->with('error_message', 'Cannot find recommendation information.');
        }
        $recommendation->delete();
        return back()->with('info_message', 'Recommendation deleted!');
    }
}
