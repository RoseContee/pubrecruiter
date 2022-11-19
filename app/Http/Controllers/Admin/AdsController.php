<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ADS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AdsController extends Controller
{
    private $menu = 'ADS';

    public function __construct()
    {
        View::share('menu', $this->menu);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = ADS::orderBy('active', 'desc')->get();
        $active = false;
        foreach ($ads as $ad) {
            if ($ad['active']) {
                $active = true;
                break;
            }
        }
        return view('admin.ads.index', [
            'ads' => $ads,
            'active' => $active,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ads.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $rule = [
            'image'     => ['required', 'image'],
            'link'      => ['required', 'url'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $ad = new ADS();
        if ($request->hasFile('image')) {
            $ad['image'] = 'uploads/'.$request->file('image')->store('ads');
        }
        $ad['link'] = $request['link'];
        if ($ad['active'] = !empty($request['active'])) {
            ADS::active()->update([
                'active' => 0,
            ]);
        }
        $ad->save();
        return redirect()->route('admin.ads.index')->with('success_message', 'AD created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $ad = ADS::find($id);
        if (!$ad) {
            return back()->with('error_message', 'Cannot find AD information.');
        }
        return view('admin.ads.edit', [
            'ad' => $ad,
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
        $ad = ADS::find($id);
        if (!$ad) {
            return back()->with('error_message', 'Cannot find AD information.');
        }
        $rule = [
            'link'      => ['required', 'url'],
        ];
        if ($request->hasFile('image')) {
            $rule['image'] = ['image'];
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        if ($request->hasFile('image')) {
            if ($ad['image'] && file_exists(public_path($ad['image']))) {
                unlink(public_path($ad['image']));
            }
            $ad['image'] = 'uploads/'.$request->file('image')->store('ads');
        }
        $ad['link'] = $request['link'];
        if ($ad['active'] = !empty($request['active'])) {
            ADS::active()->update([
                'active' => 0,
            ]);
        }
        $ad->save();
        return redirect()->route('admin.ads.index')->with('success_message', 'AD updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $ad = ADS::find($id);
        if (!$ad) {
            return back()->with('error_message', 'Cannot find AD information.');
        }
        if ($ad['image'] && file_exists(public_path($ad['image']))) {
            unlink(public_path($ad['image']));
        }
        $ad->delete();
        return back()->with('info_message', 'AD has been deleted.');
    }

    public function disableADS()
    {
        ADS::active()->update([
            'active' => 0,
        ]);
        return back();
    }
}
