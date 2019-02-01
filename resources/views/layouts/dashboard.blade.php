<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>

    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEO::generate(true) !!}

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic|Material+Icons:latin">

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'echoPort' => env('LARAVEL_ECHO_SERVER_PORT', '')
        ]) !!};
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{getenv('GOOGLE_MAPS_KEY', '')}}"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('Bootstrap/dist/css/bootstrap-reboot.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Bootstrap/dist/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Bootstrap/dist/css/bootstrap-grid.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="https://select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('/img/logo.png') }}">
    <link rel="icon" href="{{ asset('/img/logo.png') }}" type="image/x-icon">
    <meta property="og:title" content="CampusTeam is varsity ESports social media, recruiting tool and tournament platform.">
    <link rel="image_src" href="{{ asset('/img/logo.png') }}">
    <meta property="og:image" content="{{ asset('/img/logo.png') }}">

    <!-- Main Styles CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fonts.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">

    @if (app()->environment() === 'production')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130570614-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-130570614-1');
        </script>

        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-TB6VBHP');</script>
        <!-- End Google Tag Manager -->
    @endif
</head>

<body>

@if (app()->environment() === 'production')
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TB6VBHP"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@endif

<div id="app">
@include('_partials.dashboard.sidebar')
@include('_partials.dashboard.header')
@yield('content')
@include('_partials.dashboard.modals')
</div>

<script src="{{ mix('/js/app.js') }}"></script>

<!-- JS Scripts -->
<script src="{{ asset('js/jquery.appear.js') }}"></script>
<script src="{{ asset('js/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('js/jquery.matchHeight.js') }}"></script>
<script src="{{ asset('js/svgxuse.js') }}"></script>
<script src="{{ asset('js/imagesloaded.pkgd.js') }}"></script>
<script src="{{ asset('js/Headroom.js') }}"></script>
<script src="{{ asset('js/velocity.js') }}"></script>
<script src="{{ asset('js/ScrollMagic.js') }}"></script>
<script src="{{ asset('js/jquery.waypoints.js') }}"></script>
<script src="{{ asset('js/jquery.countTo.js') }}"></script>
<script src="{{ asset('js/material.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-select.js') }}"></script>
<script src="{{ asset('js/smooth-scroll.js') }}"></script>
<script src="{{ asset('js/selectize.js') }}"></script>
<script src="{{ asset('js/isotope.pkgd.js') }}"></script>
<script src="{{ asset('js/ajax-pagination.js') }}"></script>
<script src="{{ asset('js/Chart.js') }}"></script>
<script src="{{ asset('js/chartjs-plugin-deferred.js') }}"></script>
<script src="{{ asset('js/circle-progress.js') }}"></script>
<script src="{{ asset('js/loader.js') }}"></script>
<script src="{{ asset('js/run-chart.js') }}"></script>

<script src="{{ asset('js/base-init.js') }}"></script>
<script defer src="{{ asset('fonts/fontawesome-all.js') }}"></script>
<script src="{{ asset('Bootstrap/dist/js/bootstrap.bundle.js') }}"></script>
</body>
</html>