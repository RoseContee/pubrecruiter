<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class OpportunityController extends Controller
{
    private $menu = 'Opportunities';

    public function __construct()
    {
        View::share('menu', $this->menu);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $opportunities = Opportunity::with('user')
            ->orderBy('user_id')
            ->get();
        return view('admin.opportunities.index', [
            'opportunities' => $opportunities,
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
        $opportunity = Opportunity::find($id);
        if (!$opportunity) {
            return back()->with('error_message', 'Cannot find opportunity information.');
        }
        $opportunity->delete();
        return back()->with('info_message', 'Opportunity information has been deleted.');
    }
}
