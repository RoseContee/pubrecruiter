<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use App\Models\Outreach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class OutreachController extends Controller
{
    private $menu = 'Outreach';

    public function __construct()
    {
        View::share('menu', $this->menu);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outreaches = Outreach::with(['user', 'user.info.referral', 'contact', 'contact.user'])
            ->has('user')
            ->has('contact')
            ->has('contact.user')
            ->get();
        foreach ($outreaches as $outreach) {
            if ($outreach['opportunities']) {
                $outreach['opportunities'] = Opportunity::whereIn('id', explode(',', $outreach['opportunities']))
                    ->where('user_id', $outreach['owner_id'])
                    ->get();
            }
        }
        return view('admin.outreach.index', [
            'outreaches' => $outreaches,
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
        //
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
        $outreach = Outreach::find($id);
        if (!$outreach) {
            return back()->with('error_message', 'Cannot find outreach information.');
        }
        $outreach->delete();
        return back()->with('info_message', 'Outreach information has been deleted.');
    }
}
