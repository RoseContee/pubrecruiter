<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function blog(Request $request) {
        $keyword = $request['q'];
        $blogs = Blog::query()->where(function ($q) use ($keyword) {
                if ($keyword) {
                    $q->where('title', 'like', '%'.$keyword.'%')
                        ->orWhere('short_content', 'like', '%'.$keyword.'%')
                        ->orWhere('content', 'like', '%'.$keyword.'%');
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        return view('marketplace.blog.index', [
            'keyword' => $keyword,
            'blogs' => $blogs,
        ]);
    }

    public function categoryBlog($category, Request $request) {
        $keyword = $request['q'];
        $blogs = Blog::query()->where(function ($q) use ($keyword) {
                if ($keyword) {
                    $q->where('title', 'like', '%'.$keyword.'%')
                        ->orWhere('short_content', 'like', '%'.$keyword.'%')
                        ->orWhere('content', 'like', '%'.$keyword.'%');
                }
            })
            ->where('tags', 'like', '%,'.$category.',%')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        return view('marketplace.blog.index', [
            'category' => $category,
            'keyword' => $keyword,
            'blogs' => $blogs,
        ]);
    }

    public function item($slug) {
        $blog = Blog::query()->where('slug', $slug)->first();
        if (!$blog) abort(404);
        $tags = preg_split('/\s*,\s*/', trim($blog['tags']), -1, PREG_SPLIT_NO_EMPTY);
        $recommendations = Blog::where(function($q) use ($tags) {
                foreach ($tags as $tag) {
                    $q->orWhere('tags', 'like', '%,'.$tag.',%');
                }
            })
            ->get();
        for ($i = 0; $i < count($recommendations); $i++) {
            $item = $recommendations[$i];
            if ($item['id'] == $blog['id']) break;
        }
        if ($i == 0) {
            $old = $recommendations[$i + 1] ?? null;
            $new = $recommendations[$i + 2] ?? null;
        } else if ($i == count($recommendations) - 1) {
            $old = $recommendations[$i - 2] ?? null;
            $new = $recommendations[$i - 1] ?? null;
        } else {
            $old = $recommendations[$i - 1] ?? null;
            $new = $recommendations[$i + 1] ?? null;
        }
        $comments = $blog->comments()
            ->orderBy('created_at', 'desc')
            ->paginate(1)
            ->withPath(route('more-blog-comments', $blog['slug']));
        return view('marketplace.blog.item', [
            'blog' => $blog,
            'old' => $old,
            'new' => $new,
            'comments' => $comments,
        ]);
    }

    public function moreComments($slug) {
        $blog = Blog::query()->where('slug', $slug)->first();
        if (!$blog) return response()->json([], 404);
        $comments = $blog->comments()
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withPath(route('more-blog-comments', $blog['slug']));
        $comments_list = '';
        foreach ($comments as $comment) {
            $comments_list .= view('marketplace.blog.comment-item', [
                'comment' => $comment,
            ])->render();
        }
        return response()->json([
            'comments' => $comments_list,
            'next'     => $comments->nextPageUrl(),
        ]);
    }

    public function blogComment($slug, Request $request) {
        $rule = [
            'name' => ['required'],
            'email' => ['required'],
            'comment' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $blog = Blog::query()->where('slug', $slug)->first();
        if (!$blog) abort(404);
        $blog->comments()->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'comment' => $request['comment'],
        ]);
        return back();
    }
}
