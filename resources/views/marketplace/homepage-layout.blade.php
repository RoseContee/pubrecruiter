@extends('marketplace.partials.layout')

@section('header-menu')
    @if (auth()->check())
        @php
            $contact_type = auth()->user()->type == 'Creator' ? 'brands' : 'creators';
            $brands = $contact_type == 'brands';
            $keyword = $keyword ?? '';
            $c = $c ?? '';
            $n = $n ?? '';
        @endphp
        <ul class="navbar-nav ml-0 mr-lg-auto ml-lg-5 d-block d-lg-flex mt-3 mt-lg-0">
            <!-- Navbar Search -->
            <li class="nav-item">
                <form name="searchContact" action="{{ route($contact_type) }}" class="search-bar" method="GET">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control form-control-navbar"
                               value="{{ $keyword }}" placeholder="I'm looking for" aria-label="I'm looking for">
                        <div class="input-group-append">
                            @if ($brands)
                                <a href="javascript:void(0);" id="searchBrand"
                                   class="btn btn-navbar btn-main d-flex align-items-center">
                                    <i class="fas fa-search"></i>
                                </a>
                            @else
                                <button type="submit" class="btn btn-navbar btn-main">
                                    <i class="fas fa-search"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    @if ($brands)
                        <div class="d-block d-sm-flex filter-options position-absolute mt-1">
                            <div class="form-inline align-items-center mb-1 mb-sm-0">
                                <input type="hidden" name="c" value="{{ $c }}">
                                <label for="commission-sort" class="mr-3 mr-sm-2 mb-0">Sort By:</label>
                                <a href="javascript:void(0);" id="commission-sort" class="btn btn-main btn-sm">
                                    Commission
                                    @if ($c == 'asc')
                                        <i class="fa fa-sort-amount-up ml-1"></i>
                                    @elseif ($c == 'desc')
                                        <i class="fa fa-sort-amount-down ml-1"></i>
                                    @else
                                        <i class="fa fa-sort ml-1"></i>
                                    @endif
                                </a>
                            </div>
                            <div class="form-inline align-items-center ml-0 ml-sm-3">
                                <label for="network-filter" class="mr-2 mb-0">Filter By:</label>
                                <select id="network-filter" name="n" class="form-control">
                                    <option value="">Select Network</option>
                                    @foreach ($networks as $network)
                                        <option value="{{ $network }}" @if (!strcasecmp($network, $n)) selected @endif>
                                            {{ $network }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                </form>
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
    @else
        <ul class="navbar-nav align-items-center justify-content-around ml-auto">
            <li class="nav-item">
                <a href="{{ route('login') }}" class="btn text-main mr-3">
                    Login
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('create-profile') }}" class="btn btn-main">
                    Start Your Profile
                </a>
            </li>
        </ul>
    @endif
@endsection

@section('footer')
    <footer class="text-center py-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mb-3 mb-lg-0 text-lg-left">
                    <img src="{{ asset('public/assets/images/logo-footer.png') }}" alt="logo" class="logo">
                </div>
                <div class="col-lg-9">
                    <ul class="d-block d-lg-flex justify-content-end align-items-center">
                        <li class="px-2 mt-2">
                            <a href="{{ $setting['extension_link'] }}" class="btn btn-main btn-sm" target="_blank">
                                <i class="fab fa-chrome"></i> Download
                            </a>
                        </li>
                        <li class="pl-2 mt-2">
                            <span class="text-white">&copy;{{ date('Y') }} {{ $setting['site_name'] }} - All Rights Reserved</span>
                        </li>
                        <li class="pl-2 mt-2 text-white">
                            <a href="https://book.pubrecruiter.com" class="text-white ml-0 ml-lg-4 mr-2">Support</a>
                            |
                            <a href="https://book.pubrecruiter.com/policies" class="text-white ml-2">Policies</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
@endsection

@push('script')
    @auth
        <script type="text/javascript">
            @if ($brands)
                let c = '{{ $c == 'asc' ? 'asc' : ($c == 'desc' ? 'desc' : '') }}'
                $(function() {
                    $(document).on('click', '#searchBrand', function() {
                        searchBrand()
                    }).on('click', '#commission-sort', function() {
                        if (c == 'desc') c = 'asc'
                        else if (c == 'asc') c = ''
                        else c = 'desc'
                        $('[name="c"]').val(c)
                        searchBrand()
                    }).on('change', function() {
                        searchBrand()
                    })
                })

                function searchBrand() {
                    document.searchContact.submit()
                }
            @endif
        </script>
    @endauth
@endpush
