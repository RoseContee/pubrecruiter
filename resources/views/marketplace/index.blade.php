@extends('marketplace.partials.layout')

@section('title', 'Where Partnerships Are Started')

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
    <main class="mt-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-5 d-flex align-items-center mb-3">
                    <div>
                        <h1 class="banner-title mb-0">
                            Start<br class="d-none d-md-block">
                            Partnerships<br class="d-none d-md-block">
                            Here
                        </h1>
                        <div class="text-center text-md-left mb-3">
                            <img src="{{ asset('public/assets/images/home/sign.png') }}" alt="" class="img-fluid">
                        </div>
                        <div class="d-flex d-md-block d-lg-flex justify-content-between">
                            <a href="{{ route('join-as-creator') }}" class="banner-link">
                                Creator Sign Up
                            </a>
                            <a href="{{ route('join-as-brand') }}" class="banner-link">
                                Brand Sign Up
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 mb-3">
                    <img src="{{ asset('public/assets/images/home/1.png') }}" alt="image" class="w-100">
                </div>
            </div>
        </div>

        <div class="container partnership-marketer py-5">
            <div class="row">
                <div class="col-md-6 col-lg-8 d-flex align-items-center">
                    <div class="text-dark">
                        <h2 class="mb-3 mb-md-5">Built For Partnership Marketer</h2>
                        <p>There are two important functions in driving an Affiliate Program's overall success:
                            <b>Optimization and Growth</b></p>
                        <p>We aim to solve the largest problems in the space:</p>
                        <ul>
                            <li>
                                <p>Creators have no centralized place to find or manage applicable partnerships</p>
                            </li>
                            <li>
                                <p>Brand managers experience limited bandwidth to recruit new partnerships</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-flex align-items-center">
                    <img src="{{ asset('public/assets/images/home/2.png') }}" alt="image" class="w-100">
                </div>
            </div>
        </div>

        <div class="container text-center py-5">
            <div class="row">
                <div class="col-12 mb-5">
                    <h1>Organize and Track Partnerships</h1>
                </div>
                <div class="col-md-4">
                    <div class="px-3">
                        <img src="{{ asset('public/assets/images/home/3.png') }}" alt="image" class="w-100">
                    </div>
                    <h5 class="mt-3">OUR MARKETPLACE</h5>
                    <p class="text-dark">Get access to unique partnerships opportunities and proactively
                        reach out to the right contact with just a click of a button</p>
                </div>
                <div class="col-md-4">
                    <div class="px-3">
                        <img src="{{ asset('public/assets/images/home/4.png') }}" alt="image" class="w-100">
                    </div>
                    <h5 class="mt-3">TRACK OUTREACH</h5>
                    <p class="text-dark">Log outreach dates, notes, note if an IO has been signed,
                        even manually add your own Affiliate Partnership outreaches within your dashboard</p>
                </div>
                <div class="col-md-4">
                    <div class="px-3">
                        <img src="{{ asset('public/assets/images/home/5.png') }}" alt="image" class="w-100">
                    </div>
                    <h5 class="mt-3">EXPERT SUPPORT</h5>
                    <p class="text-dark">We're not just software, we're real people. Want to know more about a partner,
                        brand, or even new Affiliate technology, we're here for you.</p>
                </div>
                <div class="col-12 mt-4">
                    <a href="{{ route('create-profile') }}" class="banner-link justify-content-center">Sign Up</a>
                </div>
            </div>
        </div>

        <div class="container text-dark py-5">
            <div class="pb-md-5 pb-lg-0">
                <div class="row pb-md-4 pb-lg-0">
                    <div class="col-md-6 col-lg-7 d-flex align-items-center">
                        <div>
                            <h1 class="mb-4">Pricing</h1>
                            <p class="mb-0">Things that we don't like:</p>
                            <ul>
                                <li><p class="mb-0">Monthly fees</p></li>
                                <li><p class="mb-0">Contractual obligations</p></li>
                                <li><p class="mb-0">Squid ink pasta</p></li>
                            </ul>
                            <p>Things we like:</p>
                            <ul>
                                <li><p>Being rewarded when things work properly</p></li>
                            </ul>
                            <p>Introducing Bounty Tips:</p>
                            <p><b>Bounty Tip (noun):</b> when you see Pub Recruiter to help bridge a successful partnership,
                                grow your business, meet new connections, or keep your job safe,
                                we recommend providing a monetary tip.
                                We make this easy within your dashboard, just sayin'</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5 d-flex align-items-center">
                        <img src="{{ asset('public/assets/images/home/6.png') }}" alt="image" class="w-100">
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
