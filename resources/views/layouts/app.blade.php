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
        .socials i, .socials svg{
            font-size: 22px!important;
        }
        .btn{
            white-space: inherit;
        }

        .a2a_vertical_style{
            right:0;
            top:150px;
        }

        @media (max-width: 460px)
        {
            .a2a_vertical_style {
                bottom: 0;
                top: auto;
                position: fixed;
                text-align: center;
                width: 100%;
            }

            .a2a_vertical_style a{
                display: inline-block!important;
                clear: none!important;
            }

            .a2a_floating_style{
                border-radius: 0!important;
            }
        }
        p{
            font-size: 0.95rem;
        }
        .text-lemon{
            color: lemonchiffon;
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

        <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
            (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

            ym(52789489, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                webvisor:true
            });
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/52789489" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->

        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window,document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '1274719416037192');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1"
                 src="https://www.facebook.com/tr?id=1274719416037192&ev=PageView
&noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->
    @endif
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

    <div class="container" id="app">
        @yield('content')

    </div>
    @include('_partials.landing.footer')

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
    <script defer src="{{ asset('fonts/fontawesome-all.js') }}"></script>
</body>
</html>
