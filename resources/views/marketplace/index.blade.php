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
                            More<br class="d-none d-md-block">
                            Quality<br class="d-none d-md-block">
                            Partners
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
                    <img src="{{ asset('public/assets/images/home/1.png') }}" alt="image" class="w-85">
                </div>
            </div>
        </div>
		
        <div class="container text-center py-5">
            <div class="row">
                <div class="col-12 mb-5">
                    <h1>💯 Free Affiliate Solution</h1>
                </div>
				<div class="col-md-4">
                    <div class="px-3">
                        <img src="{{ asset('public/assets/images/home/3.png') }}" alt="image" class="w-100">
                    </div>
                    <h5 class="mt-3">Marketplace</h5>
                    <p class="text-dark">Explore partnership opportunities with just a few clicks using our marketplace</p>
                </div>
                <div class="col-md-4">
                    <div class="px-3">
                        <img src="{{ asset('public/assets/images/home/4.png') }}" alt="image" class="w-100">
                    </div>
                    <h5 class="mt-3">Innovative</h5>
                    <p class="text-dark">Use our Patent Pending Chrome Extension to find a new opportunity or useful information</p>
                </div>
                <div class="col-md-4">
                    <div class="px-3">
                        <img src="{{ asset('public/assets/images/home/5.png') }}" alt="image" class="w-100">
                    </div>
                    <h5 class="mt-3">We're Your Rock</h5>
                    <p class="text-dark">We know what it's like to always have the need to provide incremental performance.  Let us be your extra resource!  </p>
                </div>
                
            </div>
        </div>

        <div class="container text-dark py-5">
            <div class="pb-md-5 pb-lg-0">
                <div class="row pb-md-4 pb-lg-0">
                    <div class="col-md-6 col-lg-7 d-flex align-items-center">
                        <div>
                            <h2 class="mb-4">Have questions? Book a call!</h2>
                            <p class="mb-0">We can answer these...</p>
                            <ul><br>
                                <li><p class="mb-0">How do we earn?</p></li>
                                <li><p class="mb-0">How our software works</p></li>
                                <li><p class="mb-0"><a href="https://calendly.com/pubrecruiter/30min">Schedule today!</a></p></li>
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
