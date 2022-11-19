<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{ $setting['site_name'] }} Admin</title>

    <link rel="icon" type="image/png" href="{{ asset('public/'.$setting['favicon']) }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/assets/theme/css/theme.min.css') }}">
    <!-- Site Font -->
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/fonts/montserrat.css') }}">

    <!-- Custom style -->
    <link rel="stylesheet" href="{{ asset('public/assets/admin/css/custom.css') }}">

    @yield('style')

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('admin') }}" class="brand-link">
            <img src="{{ asset('public/assets/images/admin-logo.png') }}" alt="Admin Logo" class="brand-image">
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link @if ($menu == 'Users') active @endif">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li class="nav-item @if ($menu == 'Contacts') menu-open @endif">
                        <a href="#" class="nav-link @if ($menu == 'Contacts') active @endif">
                            <i class="nav-icon fas fa-address-book"></i>
                            <p>
                                Contacts
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.contacts.index', ['type' => 'brand']) }}"
                                   class="nav-link pl-4 @if (($submenu??'') == 'brand') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Brands</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.contacts.index', ['type' => 'creator']) }}"
                                   class="nav-link pl-4 @if (($submenu??'') == 'creator') active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Creators</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.metrics.index') }}" class="nav-link @if ($menu == 'Metrics') active @endif">
                            <i class="nav-icon fas fa-thumbtack"></i>
                            <p>Metrics</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.blacklists.index') }}" class="nav-link @if ($menu == 'Blacklists') active @endif">
                            <i class="nav-icon fas fa-ban"></i>
                            <p>Blacklists</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.feedback.index') }}" class="nav-link @if ($menu == 'Feedback') active @endif">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>Feedback</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.outreach.index') }}" class="nav-link @if ($menu == 'Outreach') active @endif">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p>Outreach</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.flag.index') }}" class="nav-link @if ($menu == 'Flag') active @endif">
                            <i class="nav-icon fas fa-flag"></i>
                            <p>Flag Records</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.opportunities.index') }}" class="nav-link @if ($menu == 'Opportunities') active @endif">
                            <i class="nav-icon fas fa-dollar-sign"></i>
                            <p>Opportunities</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.networks.index') }}" class="nav-link @if ($menu == 'Networks') active @endif">
                            <i class="nav-icon fas fa-network-wired"></i>
                            <p>Networks</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.sub.index') }}" class="nav-link @if ($menu == 'SUB') active @endif">
                            <i class="nav-icon fas fa-mouse"></i>
                            <p>SUB Records</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.referrals.index') }}" class="nav-link @if ($menu == 'Referrals') active @endif">
                            <i class="nav-icon fas fa-bullhorn"></i>
                            <p>Referrals</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.ads.index') }}" class="nav-link @if ($menu == 'ADS') active @endif">
                            <i class="nav-icon fas fa-ad"></i>
                            <p>ADS</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.settings') }}" class="nav-link @if ($menu == 'Settings') active @endif">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Settings</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.profile') }}" class="nav-link @if ($menu == 'Profile') active @endif">
                            <i class="nav-icon fas fa-user-circle"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.logout') }}" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @yield('content')

    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1
        </div>
        <strong>Copyright &copy; {{ date('Y') }} <a href="">{{ $setting['site_name'] }}</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('public/assets/vendor/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('public/assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/assets/vendor/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('public/assets/vendor/moment/moment.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('public/assets/vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('public/assets/vendor/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/assets/theme/js/theme.js') }}"></script>
<!-- Custom -->
<script src="{{ asset('public/assets/marketplace/js/image-load.js') }}"></script>
<script src="{{ asset('public/assets/admin/js/custom.js') }}"></script>

<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
    })
</script>

@yield('script')

</body>
</html>
