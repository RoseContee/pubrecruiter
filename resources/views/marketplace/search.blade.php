@extends('marketplace.partials.layout')

@php
    $brand_user = auth()->user()->type == 'Brand';
    $contact_type = $brand_user ? 'creators' : 'brands';
@endphp
@section('title', 'Find '.ucfirst($contact_type))

@section('header-menu')
    <ul class="navbar-nav ml-0 mr-lg-auto ml-lg-5 d-block d-lg-flex mt-3 mt-lg-0">
        <!-- Navbar Search -->
        <li class="nav-item">
            @include('marketplace.partials.search.search-bar', [
                'route' => route($contact_type)
            ])
        </li>
    </ul>

    <ul class="navbar-nav align-items-center justify-content-end ml-lg-auto right-menu">
        @include('marketplace.partials.notifications.area')

        <li class="nav-item mini-menu">
            <a href="javascript:void(0);" class="nav-link text-gray">
                <i class="fa fa-bars fa-2x"></i>
            </a>
            <ul class="navbar-nav justify-content-center">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="btn btn-main ml-xl-3">
                        My Account
                    </a>
                </li>

                @if (request()->route()->getName() == 'home')
                    <li class="nav-item">
                        <a href="{{ route($contact_type) }}" class="btn btn-main ml-3">
                            {{ ucfirst(trim($contact_type, 's')) }} Marketplace
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    </ul>
@endsection

@section('content')
    <!--Main Start-->
    <main class="container pt-5 my-5">
        @include('marketplace.partials.search.contacts')
    </main>
    <!--Main End-->
@endsection

@section('footer')
    @include('marketplace.partials.footer')
@endsection
