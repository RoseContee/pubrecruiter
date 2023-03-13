@extends('marketplace.partials.layout')

@section('title', 'Partnership Blog')

@section('header-menu')
    <ul class="navbar-nav align-items-center justify-content-around ml-auto">
        <li class="nav-item">
            <a href="{{ route('blog') }}" class="btn font-weight-bold mr-3">
                Blog
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('login') }}" class="btn btn-main btn-round fs-16 text-capitalize font-weight-bold px-5">
                Login
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <!--Main Start-->
    <main class="blog mt-5">
        <div class="container py-5">
            <h1 class="text-center">Partnership Blog</h1>
            @if (!empty($category))
                <h4 class="text-center text-capitalize text-main">({{ $category }})</h4>
            @endif
        </div>

        <div class="px-3 px-xl-5 pt-5">
            @if (count($blogs))
                <div class="row">
                    @foreach ($blogs as $blog)
                        @php
                            $tags = preg_split('/\s*,\s*/', trim($blog['tags']), -1, PREG_SPLIT_NO_EMPTY);
                        @endphp
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="blog-item shadow p-3">
                                <div class="text-center">
                                    <a href="{{ route('blog-item', $blog['slug']) }}">
                                        <img src="{{ asset('public/'.$blog['image']) }}" alt="image" class="img-fluid">
                                    </a>
                                </div>
                                <div class="blog-tags py-3">
                                    @foreach ($tags as $tag)
                                        <a href="{{ route('category-blog', $tag) }}">{{ $tag }}</a>
                                    @endforeach
                                </div>
                                <a href="{{ route('blog-item', $blog['slug']) }}">
                                    <h5>{{ $blog['title'] }}</h5>
                                    <p class="">{{ Str::limit($blog['short_content'], 200) }}</p>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3 text-center pagination-center">
                    {!! $blogs->links('vendor.pagination.simple-bootstrap-4') !!}
                </div>
            @else
                <div class="text-center">
                    <h5>No blogs found</h5>
                </div>
            @endif
        </div>
    </main>
    <!--Main End-->
@endsection
