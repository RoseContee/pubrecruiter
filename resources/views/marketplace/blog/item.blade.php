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
        <div class="container pt-5">
            <h5 class="text-center text-primary">Blog</h5>
        </div>

        <div class="container pt-3">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>{{ $blog['title'] }}</h1>
                    <p>Last Modified: {{ date('F j, Y', strtotime($blog['updated_at'])) }}</p>
                </div>
                <div class="col-12">
                    <img src="{{ asset('public/'.$blog['image']) }}" alt="image" class="w-100">
                </div>
                <div class="col-12">
                    <div class="text-dark mt-5">
                        {!! $blog['content'] !!}
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--Main End-->
@endsection
