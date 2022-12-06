<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CommissionsController extends Controller
{
    private $menu = 'Commissions';

    public function __construct()
    {
        View::share('menu', $this->menu);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commissions = Commission::with('user')
            ->orderBy('user_id')
            ->get();
        return view('admin.commissions.index', [
            'commissions' => $commissions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::creator()->orderBy('name')->get(['id', 'name', 'email']);
        return view('admin.commissions.edit', [
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rule = [
            'creator'           => ['required', 'exists:users,id'],
            'brand'             => ['required'],
            'commission'        => ['required', 'numeric'],
            'admin_commission'  => ['nullable', 'numeric'],
            'date'              => ['required', 'date'],
            'paid'              => ['boolean'],
        ];
        $validator = Validator::make($request->all(), $rule, [
            'commission.required' => 'The creator commission field is required.',
            'commission.numeric' => 'The creator commission must be a number.',
            'admin_commission.required' => 'The pub recruiter commission field is required.',
            'admin_commission.numeric' => 'The pub recruiter commission must be a number.',
            'date.required' => 'The date of transaction field is required.',
            'date.date' => 'The date of transaction is not a valid date.'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $commission                     = new Commission();
        $commission['user_id']          = $request['creator'];
        $commission['brand']            = $request['brand'];
        $commission['commission']       = $request['commission'];
        $commission['admin_commission'] = $request['admin_commission'];
        $commission['date']             = $request['date'];
        $commission['paid']             = !empty($request['paid']);
        $commission->save();
        return redirect()->route('admin.commissions.index')->with('success_message', 'Commission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $commission = Commission::find($id);
        if (!$commission) {
            return back()->with('error_message', 'Cannot find commission information.');
        }
        $users = User::creator()->orderBy('name')->get(['id', 'name', 'email']);
        return view('admin.commissions.edit', [
            'commission' => $commission,
            'users'      => $users,
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
        $commission = Commission::find($id);
        if (!$commission) {
            return back()->with('error_message', 'Cannot find commission information.');
        }
        $rule = [
            'creator'           => ['required', 'exists:users,id'],
            'brand'             => ['required'],
            'commission'        => ['required', 'numeric'],
            'admin_commission'  => ['nullable', 'numeric'],
            'date'              => ['required', 'date'],
            'paid'              => ['boolean'],
        ];
        $validator = Validator::make($request->all(), $rule, [
            'commission.required' => 'The creator commission field is required.',
            'commission.numeric' => 'The creator commission must be a number.',
            'admin_commission.required' => 'The pub recruiter commission field is required.',
            'admin_commission.numeric' => 'The pub recruiter commission must be a number.',
            'date.required' => 'The date of transaction field is required.',
            'date.date' => 'The date of transaction is not a valid date.'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $commission['user_id']          = $request['creator'];
        $commission['brand']            = $request['brand'];
        $commission['commission']       = $request['commission'];
        $commission['admin_commission'] = $request['admin_commission'];
        $commission['date']             = $request['date'];
        $commission['paid']             = !empty($request['paid']);
        $commission->save();
        return back()->with('success_message', 'Commission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $commission = Commission::find($id);
        if (!$commission) {
            return back()->with('error_message', 'Cannot find commission information.');
        }
        $commission->delete();
        return back()->with('info_message', 'Commission has been deleted.');
    }
}
