<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class ResourcesController extends Controller
{
    private $menu = 'Resources';

    public function __construct()
    {
        View::share('menu', $this->menu);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resources = Resource::orderBy('created_at', 'desc')->get();
        return view('admin.resources.index', [
            'resources' => $resources,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.resources.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rule = [
            'name' => ['required', 'unique:resources'],
            'url' => ['required', 'url', 'unique:resources'],
            'logo' => ['required', 'image'],
            'type' => ['required', 'in:Brand,Creator'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $resource = new Resource();
        $resource['name'] = $request['name'];
        $resource['url'] = $request['url'];
        $resource['logo'] = 'uploads/'.$request->file('logo')->store('resource');
        $resource['note'] = $request['note'];
        $resource['type'] = $request['type'];
        $resource->save();
        return redirect()->route('admin.resource.index')->with('success_message', 'New resource created!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $resource = Resource::find($id);
        if (!$resource) {
            return back()->with('error_message', 'Cannot find resource information.');
        }
        return view('admin.resources.edit', [
            'resource' => $resource,
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
        $resource = Resource::find($id);
        if (!$resource) {
            return back()->with('error_message', 'Cannot find resource information.');
        }
        $rule = [
            'name' => ['required', Rule::unique('resources')->ignore($resource['id'])],
            'url' => ['required', 'url', Rule::unique('resources')->ignore($resource['id'])],
            'logo' => ['nullable', 'image'],
            'type' => ['required', 'in:Brand,Creator'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $resource['name'] = $request['name'];
        $resource['url'] = $request['url'];
        if ($request->hasFile('logo')) {
            if ($resource['logo'] && file_exists(public_path($resource['logo']))) {
                unlink(public_path($resource['logo']));
            }
            $resource['logo'] = 'uploads/'.$request->file('logo')->store('resource');
        }
        $resource['note'] = $request['note'];
        $resource['type'] = $request['type'];
        $resource->save();
        return back()->with('success_message', 'Resource updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $resource = Resource::find($id);
        if (!$resource) {
            return back()->with('error_message', 'Cannot find resource information.');
        }
        if ($resource['logo'] && file_exists(public_path($resource['logo']))) {
            unlink(public_path($resource['logo']));
        }
        $resource->delete();
        return back()->with('info_message', 'Resource deleted!');
    }
}
