@extends('marketplace.partials.layout')

@prepend('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endprepend

@section ('body-class', 'dashboard')

@section('header-menu')
    @php
        $type = auth()->user()->type;
        $contact_type = $type == 'Brand' ? 'creators' : 'brands';
    @endphp
    <ul class="navbar-nav align-items-center justify-content-end ml-auto">
        @if ($menu != 'Dashboard')
            <li class="nav-item d-none d-sm-block">
                <a href="{{ route($contact_type) }}" class="btn btn-main ml-3">
                    Marketplace
                </a>
            </li>
        @endif

        @include('marketplace.partials.notifications.area')

        <li class="nav-item dropdown">
            <a href="javascript:void(0);" class="nav-link text-gray ml-2">
                <i class="fa fa-bars fa-2x"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <ul>
                    <li>
                        <a href="{{ route($contact_type) }}">{{ ucfirst(trim($contact_type, 's')) }} Marketplace</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('recommendation') }}">Recommendations</a>
                    </li>
                    <li>
                        <a href="{{ route('inbound') }}">Incoming Requests</a>
                    </li>
                    <li>
                        <a href="{{ route('outbound') }}">Sent Requests</a>
                    </li>
                    @if ($type == 'Creator')
                        <li>
                            <a href="{{ route('opportunities') }}">Opportunities</a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('favorites') }}">Favorite {{ ucfirst($contact_type) }}</a>
                    </li>
                    <li>
                        <a href="{{ route('resource') }}">Resources</a>
                    </li>
                    <li>
                        <a href="{{ route('setting') }}">Account Setting</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}">Logout</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
@endsection

@section('sidebar')
    <!--Sidebar Start-->
    <aside class="sidebar-left">
        <ul class="main-menu">
            <li @class(['active' => $menu == 'Dashboard'])>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-home text-dark"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li @class(['active' => $menu == 'Recommendation'])>
                <a href="{{ route('recommendation') }}">
                    <i class="fa fa-fire text-dark"></i>
                    <span>Recommendations</span>
                </a>
            </li>
            <li @class(['active' => $menu == 'Inbound'])>
                <a href="{{ route('inbound') }}">
                    <div>
                        <img src="{{ asset('public/assets/images/icons/incoming.png') }}" alt="incoming">
                    </div>
                    <span>Incoming Requests</span>
                </a>
            </li>
            <li @class(['active' => $menu == 'Outbound'])>
                <a href="{{ route('outbound') }}">
                    <div>
                        <img src="{{ asset('public/assets/images/icons/sent.png') }}" alt="sent">
                    </div>
                    <span>Sent Requests</span>
                </a>
            </li>
            @if ($type == 'Creator')
                <li @class(['active' => $menu == 'Opportunities'])>
                    <a href="{{ route('opportunities') }}">
                        <i class="fa fa-dollar-sign text-dark"></i>
                        <span>Opportunities</span>
                    </a>
                </li>
            @endif
            <li @class(['active' => $menu == 'Favorite'])>
                <a href="{{ route('favorites') }}">
                    <i class="far fa-heart text-dark"></i>
                    <span>Favorite {{ ucfirst($contact_type) }}</span>
                </a>
            </li>
            <li @class(['active' => $menu == 'Resource'])>
                <a href="{{ route('resource') }}">
                    <i class="far fa-thumbs-up text-dark"></i>
                    <span>Resources</span>
                </a>
            </li>
            <li @class(['active' => $menu == 'Setting'])>
                <a href="{{ route('setting') }}">
                    <i class="fa fa-cog text-dark"></i>
                    <span>Account Setting</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}">
                    <i class="fa fa-sign-out-alt text-dark"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </aside>
    <!--Sidebar End-->
@endsection

@prepend('script')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('public/assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
@endprepend
