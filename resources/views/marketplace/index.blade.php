@extends('marketplace.partials.layout')

@section('title', 'Where Partnerships Are Started')

@section('header-menu')
    <ul class="navbar-nav align-items-center justify-content-around ml-auto">
        <li class="nav-item">
            <a href="https://pubrecruiter.com/create-profile" class="btn font-weight-bold mr-3">
                Join
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
    <main class="mt-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-5 d-flex align-items-center mb-3">
                    <div>
                        <h1 class="banner-title mb-0">
                            Affiliate<br class="d-none d-md-block">
                            Marketing<br class="d-none d-md-block">
                            Made Easy
                        </h1>
                        <br>
                        <div class="d-flex d-md-block d-lg-flex justify-content-between">
                            <a href="https://pubrecruiter.com/create-profile">
							<img src="{{ asset('public/assets/images/home/gotosignup.png') }}" alt="image" align="center" class="w-75">
                            </a>
							
                        </div>
                    </div>
                </div>
                <div class="col-md-7 mb-3">
                    <img src="{{ asset('public/assets/images/home/1.png') }}" alt="image" class="w-100">
                </div>
            </div>
        </div>

        <div class="container text-center py-5">
            <div class="row">
                <div class="col-12 mb-5">
                    <h1>Research and Manage Partnerships</h1>
                </div>
                <div class="col-md-4">
                    <div class="px-3">
                        <img src="{{ asset('public/assets/images/home/3.png') }}" alt="image" class="w-100">
                    </div>
                    <h5 class="mt-3">Marketplace</h5>
                    <p class="text-dark">Explore new partnership opportunities and 
                        reach out to the right contact with just a click of a button. Find out commission rates, network location, and get exclusive deals! </p>
                </div>
                <div class="col-md-4">
                    <div class="px-3">
                        <img src="{{ asset('public/assets/images/home/4.png') }}" alt="image" class="w-100">
                    </div>
                    <h5 class="mt-3">Outreach</h5>
                    <p class="text-dark">Get notified when a partner wants to work with you, add your own notes,
                        you can even add your own Affiliate Partnership outreaches within your dashboard.</p>
                </div>
                <div class="col-md-4">
                    <div class="px-3">
                        <img src="{{ asset('public/assets/images/home/5.png') }}" alt="image" class="w-100">
                    </div>
                    <h5 class="mt-3">Support</h5>
                    <p class="text-dark">Get partner recommendations through our own proprietary process, and let us know directly if you want to know more about a partner using our Chrome Extension!</p>
                </div>
                <div class="col-12 mt-4">
                    <a href="{{ route('create-profile') }}" class="banner-link justify-content-center">Sign Up</a>
                </div>
            </div>
        </div>

		<center><img src="{{ asset('public/assets/images/home/usedby.png') }}"></center>

        <div class="container text-dark py-5">
            <div class="pb-md-5 pb-lg-0">
                <div class="row pb-md-4 pb-lg-0">
                    <div class="col-md-6 col-lg-7 d-flex align-items-center">
                        <div>
                            <h2 class="mb-4">Award Winning Content</h2>
                            <p class="mb-0">10+ Years in Affiliate and Partnership Marketing</p>
                            <ul><br>
                                <li><p class="mb-0">Start Building Your Affiliate Business</p></li>
                                <li><p class="mb-0">Content and Website Partnership Concepts</p></li>
                                <li><p class="mb-0">Brand and Program Optimization Ideas</p></li>
                            </ul>
                            
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5 d-flex align-items-center">
						<a href="https://pubrecruiter.com/blog">
                        <img src="{{ asset('public/assets/images/home/pricing.png') }}" alt="image" class="w-75"></a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--Main End-->
@endsection

@section('footer')
    @include('marketplace.partials.footer')
@endsection
