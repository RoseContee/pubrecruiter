<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class FeedbackController extends Controller
{
    private $menu = 'Feedback';

    public function __construct()
    {
        View::share('menu', $this->menu);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = Feedback::query()
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.feedback.index', [
            'feedbacks' => $feedbacks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $feedback = Feedback::query()->with(['user'])->find($id);
        if (!$feedback) {
            return back()->with('error_message', 'Cannot find feedback information.');
        }
        $users = User::get();
        return view('admin.feedback.edit', [
            'feedback' => $feedback,
            'users' => $users,
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
        $feedback = Feedback::query()->find($id);
        if (!$feedback) {
            return back()->with('error_message', 'Cannot find feedback information.');
        }
        $rule = [
            'user' => ['required', 'exists:users,id'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $response_time = in_array($request['response_time'], [1, 2, 3, 4]) ? $request['response_time'] : null;
        $feedback['response_time'] = $response_time;
        $feedback['comment'] = $request['comment'];
        $feedback['user_id'] = $request['user'];
        $feedback->save();
        return back()->with('info_message', 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $feedback = Feedback::query()->find($id);
        if (!$feedback) {
            return back()->with('error_message', 'Cannot find feedback information.');
        }
        $feedback->delete();
        return back()->with('info_message', 'Feedback information has been deleted.');
    }
}
