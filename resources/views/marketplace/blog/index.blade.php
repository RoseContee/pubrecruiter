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
        <div class="container">
            <h1 class="text-center pt-5">Partnership Blog</h1>
            @if (!empty($category))
                <h4 class="text-center text-capitalize text-main">({{ $category }})</h4>
            @endif

            <div class="row mt-5">
                <div class="col-12 offset-md-3 col-md-6 offset-lg-4 col-lg-4">
                    <form action="" method="GET">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control form-control-navbar"
                                   value="{{ $keyword }}" placeholder="I'm looking for" aria-label="I'm looking for">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-navbar btn-main">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="pt-3">
                @if (count($blogs))
                    <div class="row">
                        @foreach ($blogs as $blog)
                            @php
                                $tags = preg_split('/\s*,\s*/', trim($blog['tags']), -1, PREG_SPLIT_NO_EMPTY);
                            @endphp
                            <div class="col-md-6 col-lg-4">
                                <div class="blog-item shadow p-3 mt-3">
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
                    <div class="text-center py-5">
                        <h5>No blogs found</h5>
                    </div>
                @endif
            </div>
        </div>
    </main>
    <!--Main End-->
@endsection
