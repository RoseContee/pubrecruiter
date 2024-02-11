<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NoContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class FlagController extends Controller
{
    private $menu = 'Flag';

    public function __construct()
    {
        View::share('menu', $this->menu);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = NoContact::query()
            ->with(['user'])
            ->has('user')
            ->orderBy('domain')
            ->get();
        return view('admin.flag.index', [
            'records' => $records
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
        $record = NoContact::query()->find($id);
        if (!$record) {
            return back()->with('error_message', 'Cannot find flag record information.');
        }
        $record->delete();
        return back()->with('info_message', 'Flag record information has been deleted.');
    }
}
