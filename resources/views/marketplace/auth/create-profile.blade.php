@extends('marketplace.auth.layout')

@section('title', 'Select Account Type')

@section('content')
    <!--Main Start-->
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-8 col-lg-6">
                <div class="profile-select text-center">
                    <h4>Select Account Type</h4>
                    <h5 class="font-weight-normal">Which type do you want to select?</h5>
                </div>
            </div>
        </div>
        <div class="d-sm-flex justify-content-sm-center">
            <div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-3">
                <div class="profile-type mb-3 mb-sm-0">
                    <figure>
                        <img src="{{ asset('public/assets/images/icons/brand.png') }}"
                             alt="Join As Brand">
                    </figure>
                    <h5 class="profile-title">
                        <a href="{{ route('join-as-brand') }}">Brand</a>
                    </h5>
                    <div class="profile-detail">
                        <p>Stores, Apps, Services</p>
                        <a href="{{ route('join-as-brand') }}">Start <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-3">
                <div class="profile-type">
                    <figure>
                        <img src="{{ asset('public/assets/images/icons/creator.png') }}"
                             alt="Join As Creator">
                    </figure>
                    <h5 class="profile-title">
                        <a href="{{ route('join-as-creator') }}">Creator</a>
                    </h5>
                    <div class="profile-detail">
                        <p>Affiliates, Bloggers, Influencers</p>
                        <a href="{{ route('join-as-creator') }}">Start <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--Main End-->
@endsection
