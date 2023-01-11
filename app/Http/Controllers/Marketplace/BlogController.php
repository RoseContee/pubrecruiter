<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blog() {
        $blogs = Blog::orderBy('created_at', 'desc')
            ->paginate(1);
        return view('marketplace.blog.index', [
            'blogs' => $blogs,
        ]);
    }

    public function item($slug) {
        $blog = Blog::where('slug', $slug)->first();
        if (!$blog) abort(404);
        return view('marketplace.blog.item', [
            'blog' => $blog,
        ]);
    }
}
