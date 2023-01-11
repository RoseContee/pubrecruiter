@extends('marketplace.dashboard.layout')

@section('title', $menu.' Requests')

@push('style')
    <style type="text/css">
        .recommendations .alert,
        .recommendations .card {
            min-height: 10rem;
        }
    </style>
@endpush

@php
    $brand_user = auth()->user()->type == 'Brand';
@endphp

@section('content')
    <!--Main Start-->
    <main id="main-container">
        <div class="row recommendations">
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <a href="{{ route('recommendation') }}">
                            You have {{ $recommendation }} new recommended partner{{ $recommendation > 0 ? 's' : '' }}
                        </a>
                    </div>
                </div>
            </div>
            @if (!$brand_user)
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <a href="{{ route('opportunities') }}">
                                You have {{ $opportunity }} {{ $opportunity > 0 ? 'opportunities' : 'opportunity' }} expiring,
                                time to update!
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <a href="{{ route('resource') }}">
                            Check out the {{ $resource }} new resource{{ $resource > 0 ? 's' : '' }} could help
                            boost your brand
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <a href="{{ route('favorites') }}">
                            You have {{ $favorite }} favorite partner{{ $favorite > 0 ? 's' : '' }},
                            have you completed your partnerships with them?
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--Main End-->
@endsection
