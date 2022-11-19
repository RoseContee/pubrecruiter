<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Network;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class NetworksController extends Controller
{
    private $menu = 'Networks';

    public function __construct()
    {
        View::share('menu', $this->menu);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $networks = Network::get();
        return view('admin.networks.index', [
            'networks' => $networks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.networks.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request['link']) {
            $request['link'] = str_replace('{USERID}', '+USERID+', $request['link']);
        }
        $rule = [
            'name'  => ['required', 'unique:networks,name'],
            'link'  => ['required', 'url'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $network            = new Network();
        $network['name']    = $request['name'];
        $network['link']    = str_replace('+USERID+', '{USERID}', $request['link']);
        $network->save();

        $network->otherContacts()->update([
            'network_id'    => $network['id'],
            'network_link'  => $network['link'],
        ]);
        return redirect()->route('admin.networks.index')->with('success_message', 'Network created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $network = Network::find($id);
        if (!$network) {
            return back()->with('error_message', 'Cannot find network information.');
        }
        return view('admin.networks.edit', [
            'network'   => $network,
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
        $network = Network::find($id);
        if (!$network) {
            return back()->with('error_message', 'Cannot find network information.');
        }
        if ($request['link']) {
            $request['link'] = str_replace('{USERID}', '+USERID+', $request['link']);
        }
        $rule = [
            'name'  => ['required', Rule::unique('networks')->ignore($network['id'])],
            'link'  => ['required', 'url'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $network['name']    = $request['name'];
        $network['link']    = str_replace('+USERID+', '{USERID}', $request['link']);
        $network->save();

        $network->contacts()->update([
            'name'          => $network['name'],
            'network_link'  => $network['link'],
        ]);
        return back()->with('success_message', 'Network updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $network = Network::find($id);
        if (!$network) {
            return back()->with('error_message', 'Cannot find network information.');
        }
        $network->delete();
        return back()->with('info_message', 'Network has been deleted.');
    }
}
