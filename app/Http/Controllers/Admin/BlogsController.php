<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BlogsController extends Controller
{
    private $menu = 'Blogs';

    public function __construct()
    {
        View::share('menu', $this->menu);
    }
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->get();
        return view('admin.blogs.index', [
            'blogs' => $blogs,
        ]);
    }

    public function create()
    {
        return view('admin.blogs.edit');
    }

    public function store(Request $request)
    {
        $rule = [
            'title' => ['required'],
            'image' => ['required', 'image'],
            'short_content' => ['required'],
            'content' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $title = $request['title'];
        $slug = preg_replace('/[^a-zA-Z0-9-_]/', '-', $title);
        while (Blog::where('slug', $slug)->exists()) $slug .= '-';
        $blog = new Blog();
        $blog['title'] = $title;
        $blog['slug'] = $slug;
        $blog['image'] = 'uploads/'.$request->file('image')->store('blog');;
        $blog['short_content'] = $request['short_content'];
        $blog['content'] = $request['content'];
        $blog->save();
        return redirect()->route('admin.blogs.index')->with('success_message', 'Blog added successfully.');
    }

    public function show($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return back()->with('error_message', 'Cannot find blog information.');
        }
        return view('admin.blogs.edit', [
            'blog' => $blog,
        ]);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return back()->with('error_message', 'Cannot find blog information.');
        }
        $rule = [
            'title' => ['required'],
            'image' => ['nullable', 'image'],
            'short_content' => ['required'],
            'content' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_message', 'Make sure all validation rules.');
        }
        $title = $request['title'];
        $slug = preg_replace('/[^a-zA-Z0-9-_]/', '-', $title);
        while (Blog::where('id', '<>', $id)->where('slug', $slug)->exists()) $slug .= '-';
        $blog['title'] = $title;
        $blog['slug'] = $slug;
        if ($request->hasFile('image')) {
            if ($blog['image'] && file_exists(public_path($blog['image']))) {
                unlink(public_path($blog['image']));
            }
            $blog['image'] = 'uploads/'.$request->file('image')->store('blog');
        }
        $blog['short_content'] = $request['short_content'];
        $blog['content'] = $request['content'];
        $blog->save();
        return redirect()->route('admin.blogs.index')->with('success_message', 'Blog updated successfully.');
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return back()->with('error_message', 'Cannot find blog information.');
        }
        if ($blog['image'] && file_exists(public_path($blog['image']))) {
            unlink(public_path($blog['image']));
        }
        $blog->delete();
        return back()->with('info_message', 'Blog has been deleted.');
    }
}
