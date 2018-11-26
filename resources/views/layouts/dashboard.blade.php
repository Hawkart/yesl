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

    <script src="https://maps.googleapis.com/maps/api/js?key={{getenv('GOOGLE_MAPS_KEY', '')}}"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('Bootstrap/dist/css/bootstrap-reboot.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Bootstrap/dist/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Bootstrap/dist/css/bootstrap-grid.css') }}">

    <!-- Main Styles CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fonts.min.css') }}">

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
            position: absolute !important;
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
            /*height: 300px;*/
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

        .friend-header-thumb{
            max-height: 150px;
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

        .back-to-top{
            right: 15px;
        }

        .chat-dialog-form, .map-popup, .repost-dialog-form{
            width: 600px;
        }

        .repost-dialog-form .btn{
            float: right;
            margin-bottom: 0;
            margin-top: 15px;
        }

        .news-feed-form .author-thumb img{
            width: 40px;
            height: 40px;
        }

        .comments-list .post__author img{
            width: 30px;
            height: 30px;
        }

        .pin-google{
            color: #7c5ac2;
            padding: 4px 9px;
            width: 20px;
            height: 20px;
            font-size: 14px;
            display: inline-block;
            text-align: center;
            line-height: 20px;
            position: relative;
            top: -1px;
            margin-left: 0;
        }

        .university-overlay{
            max-height: 300px;
            overflow: hidden;
            border-radius: 5px;
            /*height: 300px;*/
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }

        .verified{
            width: 16px;
            height: 16px;
            border-radius: 100%;
            background-color: #6ec4f7;
            color: #fff;
            font-size: 6px;
            display: inline-block;
            text-align: center;
            line-height: 16px;
            position: relative;
            top: -6px;
            margin-left: 5px;
        }

        .left-menu .left-menu-icon{
            margin-right: 0;
        }

        .modal-content{
            width: 100%;
        }

        .__image_body{
            border: 3px solid #fff;
            cursor: pointer;
        }

        .university-article .post-thumb{
            align-items: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .university-article .post-thumb a{
            width: 100%;
        }

        .form-group.with-button button{
            color: #fff;
            background-color: #002650;
            border-color: #002650;
        }

        .accept-request{
            background-color: #002650;/*003a50;*/
        }

        .left-menu li a{
            position: relative;
        }

        .left-menu li a .label-avatar{
            width: 19px;
            height: 19px;
            line-height: 19px;
            top: 8px;
            right: 10px;
        }

        .w-personal-info li{
            padding: 8px 0;;
        }

    </style>
</head>

<body>

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

<script src="{{ asset('js/base-init.js') }}"></script>
<script defer src="{{ asset('fonts/fontawesome-all.js') }}"></script>
<script src="{{ asset('Bootstrap/dist/js/bootstrap.bundle.js') }}"></script>
</body>
</html>