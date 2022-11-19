@extends('marketplace.partials.layout')

@section('header-menu')
    <ul class="navbar-nav align-items-center justify-content-around ml-auto auth">
        <li class="nav-item">
            <a href="{{ route('join-as-brand') }}" class="btn">
                Join As Brand
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('join-as-creator') }}" class="btn text-main">
                Join As Creator
            </a>
        </li>
    </ul>
@endsection

@prepend('script')
    <!-- Custom JS -->
    <script src="{{ asset('public/assets/marketplace/js/image-load.js') }}"></script>
@endprepend
