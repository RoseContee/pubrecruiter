<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Metric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class MetricsController extends Controller
{
    private $menu = 'Metrics';

    public function __construct()
    {
        View::share('menu', $this->menu);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $metrics = Metric::get();
        return view('admin.metrics.index', [
            'metrics' => $metrics
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.metrics.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rule = [
            'type' => ['required', 'unique:metrics'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $metric = new Metric();
        $metric['type'] = $request['type'];
        $metric->save();
        return redirect()->route('admin.metrics.index')->with('success_message', 'Metric created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $metric = Metric::find($id);
        if (!$metric) {
            return back()->with('error_message', 'Cannot find metric information.');
        }
        return view('admin.metrics.edit', [
            'metric' => $metric,
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
        $metric = Metric::find($id);
        if (!$metric) {
            return back()->with('error_message', 'Cannot find metric information.');
        }
        $rule = [
            'type' => ['required', Rule::unique('metrics')->ignore($metric['id'])]
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $metric['type'] = $request['type'];
        $metric->save();
        return back()->with('success_message', 'Metric updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $metric = Metric::find($id);
        if (!$metric) {
            return back()->with('error_message', 'Cannot find metric information.');
        }
        $metric->metrics()->delete();
        $metric->delete();
        return back()->with('info_message', 'Metric has been deleted.');
    }
}
