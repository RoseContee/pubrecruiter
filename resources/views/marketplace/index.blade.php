@extends('marketplace.homepage-layout')

@section('title', 'Where Partnerships Are Started')

@push('style')
    @guest
        <style type="text/css">
            @media (min-width: 768px) {
                .contacts-list > .col-12:first-child {
                    border-right: solid 1px #9f9f9f;
                }

                .contacts-list > .col-12:nth-child(2) {
                    border-left: solid 1px #9f9f9f;
                }
            }
        </style>
    @endguest
@endpush

@section('content')
    <!--Main Start-->
    <main class="container pt-5 my-5">
        <div class="how-to-use mb-3">
            <h4 class="text-center mb-4"> Partnerships 🤝 Marketplace</h4>
            <div class="border border-dark px-3 py-2">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <span class="number">1</span>
                        <h5 class="font-weight-bold">Start Account</h5>
                        <p class="mb-1"><span class="creator">Creators</span>: (Blogs, Influencers)</p>
                        <p class="mb-1"><span class="brand">Brands</span>: (Shops, Services)</p>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <span class="number">2</span>
                        <h5 class="font-weight-bold">Browse Marketplace</h5>
                        <p class="mb-1"><span class="creator">Creators</span> access Brand partnerships</p>
                        <p class="mb-1"><span class="brand">Brands</span> access Creator opportunities</p>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <span class="number">3</span>
                        <h5 class="font-weight-bold">Track Partnerships</h5>
                        <p class="mb-1">See a potential opportunity?  Request a partnership and they'll be a notified!
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <span class="number">4</span>
                        <h5 class="font-weight-bold">Earn More 💸</h5>
                        <p class="mb-1">Creators get exclusive access to Affiliate links and additional brand opportunities!</p>
                    </div>
                </div>
            </div>
        </div>
        <!--Brands Start-->
        <div class="row contacts-list">
            @foreach ($contacts as $contact_type => $brands)
                <div class="col-12 @guest col-md-6 @endguest mt-5">
                    <div class="row mb-2">
                        <div class="col-12 text-center">
                            <h4 class="mb-0">{{ ucfirst($contact_type) }}</h4>
                            <a href="{{ route($contact_type) }}" class="float-right font-weight-bold">See All</a>
                        </div>
                    </div>
                    <div class="row">
                        @forelse ($brands as $contact)
                            @include('marketplace.partials.contact.item', [
                                'class' => auth()->check() ? '' : 'col-12 col-xs-6 col-sm-6 col-md-12 col-lg-6 pb-4 '.$contact['type']
                            ])
                        @empty
                            <div class="col-12 text-center py-5">
                                <h4 class="my-5 font-weight-normal">
                                    <a href="{{ route($contact_type) }}">
                                        Click here to find the {{ $contact_type }}
                                    </a>
                                </h4>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
        <!--Brands End-->
    </main>
    <!--Main End-->
@endsection

@push('script')
    @include('marketplace.partials.contact.script')
@endpush
