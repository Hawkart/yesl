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

    <!-- Main Font -->
    <script src="{{ asset('js/webfontloader.min.js') }}"></script>

    <script>
        WebFont.load({
            google: {
                families: ['Roboto:300,400,500,700:latin']
            }
        });
    </script>

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'echoPort' => env('LARAVEL_ECHO_SERVER_PORT', '')
        ]) !!};
    </script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('/img/logo.png') }}">
    <link rel="icon" href="{{ asset('/img/logo.png') }}" type="image/x-icon">
    <meta property="og:title" content="CampusTeam is professional social network for Esports community">
    <link rel="image_src" href="{{ asset('/img/logo.png') }}">
    <meta property="og:image" content="{{ asset('/img/logo.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('Bootstrap/dist/css/bootstrap-reboot.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Bootstrap/dist/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Bootstrap/dist/css/bootstrap-grid.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="https://select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css">

    <!-- Main Styles CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fonts.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/landing.css') }}">

    @include('_partials.header_analytics')
</head>

<body class="landing-page">

    @if (app()->environment() === 'production')
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TB6VBHP"
                          height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif

    @include('_partials.landing.header')
    <div class="content-bg-wrap"></div>
    <div @if(Route::currentRouteName()!='welcome') class="container" @endif id="app">
        @yield('content')
    </div>
    @include('_partials.landing.footer')

    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.appear.js') }}"></script>
    <script src="{{ asset('js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('js/jquery.matchHeight.js') }}"></script>
    <script src="{{ asset('js/svgxuse.js') }}"></script>
    <script src="{{ asset('js/Headroom.js') }}"></script>
    <script src="{{ asset('js/material.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('js/base-init.js') }}"></script>
    <script defer src="{{ asset('fonts/fontawesome-all.js') }}"></script>
</body>
</html>
