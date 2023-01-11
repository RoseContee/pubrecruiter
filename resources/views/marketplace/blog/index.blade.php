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
        </div>

        <div class="px-3 px-xl-5 pt-5">
            @if (count($blogs))
                <div class="row">
                    @foreach ($blogs as $blog)
                        <div class="col-sm-6 col-md-4">
                            <a href="{{ route('blog-item', $blog['slug']) }}">
                                <img src="{{ asset('public/'.$blog['image']) }}" alt="image" class="img-fluid">
                            </a>
                            <a href="{{ route('blog-item', $blog['slug']) }}" class="text-dark">
                                <h5 class="pt-4">{{ $blog['title'] }}</h5>
                                <p>{{ Str::limit($blog['short_content'], 200) }}</p>
                            </a>
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
