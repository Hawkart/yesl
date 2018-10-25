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
    <!--<script src="{{ asset('/js/webfontloader.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ['Roboto:300,400,500,700:latin']
            }
        });
    </script>-->

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic|Material+Icons:latin">

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'echoPort' => env('LARAVEL_ECHO_SERVER_PORT', '')
        ]) !!};
    </script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('Bootstrap/dist/css/bootstrap-reboot.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Bootstrap/dist/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Bootstrap/dist/css/bootstrap-grid.css') }}">

    <!-- Main Styles CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fonts.min.css') }}">
</head>

<body>

<div id="app">
@include('_partials.dashboard.sidebar')
@include('_partials.dashboard.header')
@yield('content')
@include('_partials.dashboard.modals')
</div>

<script src="{{ mix('/js/app.js') }}"></script>

<style>
    .alert-dismissible .close{
        margin: 0;
    }
    .choose-photo-item .checkbox .checkbox-material .check {
        background: #fff;
    }
    .choose-photo-item .checkbox .checkbox-material {
        position: absolute;
        top: 10px;
        right: 30px;
        left: auto;
    }
    .choose-photo-item.game-choose{
        width: 25%;
    }
    #game-list-container{
        position: relative;
        width: 100%;
        height: 400px;
        margin-bottom: 20px;
    }
    .friend-requests .notification-icon {
        margin-top: 20px;
    }
    .news-feed-form .author-thumb{
        top: 18px;
    }
    .emoji-picker-container{
        width: 100% !important;
        padding-left: 60px;
        padding-right: 7px;
    }
    .emoji-wysiwyg-editor{
        width: 100% !important;
    }
    .post-add-icon.active{
        fill:#ff5e3a;
        color:#ff5e3a;
    }
    .post-block-photo a{
        height: 120px;
        margin-bottom: 10px;
    }

    /*Upload avatar*/
    .top-header.top-header-favorit .top-header-author{
        transform: none;
        max-width: 100%;
        z-index: 100;
    }
    .top-header.top-header-favorit .author-thumb{
        position: relative;
    }
    .fileupload{
        position: absolute;
        top: 50px;
        left: 40px;
    }
    .fileupload:hover{
        color:#ff5e3a;
    }
    .fileupload span{
        display: none;
    }
    .top-header-thumb .author-thumb:hover span{
        display: block;
        border: 1px solid;
        padding: 3px 6px;
        border-radius: 3px;
        color: #fff;
        cursor: pointer;
    }

    .top-header-thumb .top-header-overlay{
        z-index: 100;
        max-height: 300px;
        overflow: hidden;
    }

    .top-header-thumb .top-header-overlay .fileupload{
        right: 40px;
        top: 40px;
        left: inherit;
        z-index: 101;
    }

    .top-header-thumb .top-header-overlay .fileupload span{
        display: block;
        border: 1px solid;
        padding: 3px 6px;
        border-radius: 3px;
        color: #fff;
        cursor: pointer;
    }

    .g-core-image-upload-form input{
        cursor: pointer;
    }

    .add-options-message{
        border-top: 1px solid #e6ecf5;
    }
    .links{
        padding: 0 25px;
    }
    .post .links{
        padding: 0;
    }
    .post .links img{
        max-height: 130px;
        max-width: 200px;
        width: auto;
    }
    .pa-0{
        padding: 0!important;
    }
    .author-thumb img{
        max-width: 100%;
    }

    .chat-field .ps{
        height: 350px;
    }
    #chatsDisplay.ps{
        height: 560px;
    }

    .notification-list li.active{
        background-color: #fafbfd;
    }
    .notification-list li{
        padding: 15px 25px;
    }
    .chat-message-field .chat-message-item{
        margin-top: 5px;
    }

    .comment-form .reply_on{
        margin-right: 15px;
        float: right;
        margin-bottom: 0;
        margin-top: 17px;
        padding: .8rem 1.1rem;
        font-size: .688rem;
    }

    .close-reply svg{
        height: .688rem;
    }
</style>

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
<script src="{{ asset('js/swiper.jquery.js') }}"></script>
<script src="{{ asset('js/moment.js') }}"></script>
<script src="{{ asset('js/daterangepicker.js') }}"></script>
<script src="{{ asset('js/simplecalendar.js') }}"></script>
<script src="{{ asset('js/fullcalendar.js') }}"></script>
<script src="{{ asset('js/isotope.pkgd.js') }}"></script>
<script src="{{ asset('js/ajax-pagination.js') }}"></script>
<script src="{{ asset('js/Chart.js') }}"></script>
<script src="{{ asset('js/chartjs-plugin-deferred.js') }}"></script>
<script src="{{ asset('js/circle-progress.js') }}"></script>
<script src="{{ asset('js/loader.js') }}"></script>
<script src="{{ asset('js/run-chart.js') }}"></script>
<script src="{{ asset('js/jquery.magnific-popup.js') }}"></script>
<script src="{{ asset('js/jquery.gifplayer.js') }}"></script>
<script src="{{ asset('js/mediaelement-and-player.js') }}"></script>
<script src="{{ asset('js/mediaelement-playlist-plugin.min.js') }}"></script>

<script src="{{ asset('js/base-init.js') }}"></script>
<script defer src="{{ asset('fonts/fontawesome-all.js') }}"></script>
<script src="{{ asset('Bootstrap/dist/js/bootstrap.bundle.js') }}"></script>
</body>
</html>