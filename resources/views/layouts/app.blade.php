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
    <meta property="og:title" content="CampusTeam is varsity ESports social media, recruiting tool and tournament platform.">
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
    <style>
        .registration-login-form{
            padding-left: 0;
            border-radius: 0;
            min-height: 200px;
        }
        body{
            background: #003a50;
        }
        .pa-0{
            padding: 0!important;
        }
        .landing-page .content-bg-wrap{
            -webkit-animation: none;
            animation: none;
        }

        .landing-page .content-bg-wrap:before {
            background-color: rgba(0,58,80,0.8);
        }
        .ui-block-title.ui-block-title-small .title{
            font-size: 11px;
        }

        /**
         ** Select-2
         */
        .select2-container--default .select2-selection--single{
            border: 1px solid #e6ecf5;
        }

        .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--single .select2-selection__arrow{
            height: 50px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 50px;
        }

        .alert-dismissible .close{
            top: 0;
        }

        /**
         ** Calendar
         */
        .vdp-datepicker__calendar{
            width: 260px !important;
        }
        .vdp-datepicker.is-invalid input
        {
            border-color: #dc3545;
        }
        .vdp-datepicker__calendar .cell{
            height: 28px !important;
            line-height: 28px !important;
        }

         .btn-blue {
             background-color: #1b76bc;
         }
        .btn-blue:hover {
            opacity: 1;
            color: #fff;
            background-color: #1a5d90;
        }
        .btn-lg{
            text-transform: uppercase;
            font-weight: 500;
            font-size: 0.975rem;
        }

        /*Cookie*/
          .cookiealert {
              position: fixed;
              bottom: 0;
              left: 0;
              width: 100%;
              margin: 0 !important;
              z-index: 999;
              opacity: 0;
              border-radius: 0;
              transform: translateY(100%);
              transition: all 500ms ease-out;
              color: #ecf0f1;
              background: #212327;
          }

        .cookiealert.show {
            opacity: 1;
            transform: translateY(0%);
            transition-delay: 1000ms;
        }

        .cookiealert a {
            text-decoration: underline
        }

        .cookiealert .acceptcookies {
            margin-left: 10px;
            vertical-align: baseline;
        }
    </style>

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

<body class="landing-page pb-100">
    @if (app()->environment() === 'production')
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TB6VBHP"
                          height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif

    @include('_partials.landing.header')

    <div class="content-bg-wrap"></div>

    <div class="container" id="app">
        @yield('content')
        @include('_partials.landing.footer')
    </div>

    <div class="alert text-center cookiealert" role="alert">
        Our website uses first-party and third-party cookies to improve our services and show you content and advertising according to your preferences through the analysis of your browsing habits.<br>
        By continuing to browse this website you accept this use of cookies. For more information about cookies, please visit our <a href="/cookies-policy" class="text-white">сookies policy</a>.
        <button type="button" class="btn btn-primary btn-sm acceptcookies mb-0" aria-label="Close">
            I agree
        </button>
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
    <script src="{{ asset('js/material.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('js/smooth-scroll.js') }}"></script>
    <script src="{{ asset('js/selectize.js') }}"></script>
    <script src="{{ asset('js/isotope.pkgd.js') }}"></script>
    <script src="{{ asset('js/base-init.js') }}"></script>
    <script src="{{ asset('js/cookie.js') }}"></script>
    <script defer src="{{ asset('fonts/fontawesome-all.js') }}"></script>
</body>
</html>
