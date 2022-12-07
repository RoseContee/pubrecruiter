<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $setting['site_name'] }} | @yield('title')</title>
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('public/'.$setting['favicon']) }}"/>


    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/assets/theme/css/theme.min.css') }}">
    <!-- Site Font -->
    <link rel="stylesheet" href="{{ asset('public/assets/vendor/fonts/montserrat.css') }}">

    <!-- Custom style -->
    <link rel="stylesheet" href="{{ asset('public/assets/marketplace/css/custom.css') }}?t={{ time() }}">

    @stack('style')
</head>
<body class="@yield('body-class')">

<!-- Preloader Start -->
<div class="preloader-outer">
    <div class="loader"></div>
</div>

<!-- Preloader End -->
<div id="main-wrapper">
    <header class="container-fluid bg-white py-2">
        <!-- Navbar -->
        <nav class="navbar navbar-expand d-block {{ auth()->check() ? 'd-lg-flex' : 'd-sm-flex' }}">
            <ul class="navbar-nav justify-content-center mb-2 mb-sm-0">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ asset('public/'.$setting['site_logo']) }}" alt="logo">
                    </a>
                </li>
            </ul>

            @yield('header-menu')
        </nav>
        <!-- /.navbar -->
    </header>

    @yield('sidebar')

    <div class="wrapper">

        @yield('content')

    </div>
    <!-- ./wrapper -->

    @yield('footer')

</div>

<!-- jQuery -->
<script src="{{ asset('public/assets/vendor/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Custom -->
<script src="{{ asset('public/assets/marketplace/js/custom.js') }}?t={{ time() }}"></script>

<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
    })
</script>

@stack('script')

</body>
</html>
