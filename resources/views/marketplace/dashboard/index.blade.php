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
    $contact_type = $brand_user ? 'creators' : 'brands';
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
        <div class="bg-white p-2">
            <div class="mb-5 pb-5">
                @include('marketplace.partials.search.search-bar', [
                    'route' => route('dashboard')
                ])
            </div>
            @include('marketplace.partials.search.contacts', [
                'class' => 'col-12 col-xs-6 col-sm-12 col-md-6 col-lg-4 col-xl-3 pb-4'
            ])
        </div>
    </main>
    <!--Main End-->
@endsection
