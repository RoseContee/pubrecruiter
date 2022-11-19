<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blacklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BlacklistsController extends Controller
{
    private $menu = 'Blacklists';

    public function __construct()
    {
        View::share('menu', $this->menu);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blacklists = Blacklist::get();
        return view('admin.blacklists.index', [
            'blacklists' => $blacklists,
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
     */
    public function store(Request $request)
    {
        $rule = [
            'website' => ['required', 'url'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $website = $request['website'];
        $domain = $request['domain'] = getDomain($website, $influencer);
        $rule = [
            'domain' => ['required']
        ];
        $validator = Validator::make($request->all(), $rule, [
            'domain.required' => $influencer ? 'Social media URL must be valid URL.'
                                    : 'This domain could not be found. Please check again.'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        Blacklist::updateOrCreate([
            'domain' => $domain
        ]);
        return back()->with('success_message', 'Website has been added to the blacklist.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $website = Blacklist::where('id', $id)->first();
        if (!$website) {
            return back()->with('error_message', 'Cannot find website information');
        }
        $website->delete();
        return back()->with('info_message', 'Website has been removed from the blacklist.');
    }
}
