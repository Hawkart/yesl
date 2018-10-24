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

    <script src="https://unpkg.com/vue@2.1.10/dist/vue.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('Bootstrap/dist/css/bootstrap-reboot.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Bootstrap/dist/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Bootstrap/dist/css/bootstrap-grid.css') }}">

    <!-- Main Styles CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fonts.min.css') }}">
</head>

<body class="landing-page">

    @include('_partials.landing.header')

    <div class="content-bg-wrap"></div>

    <div class="container" id="vue-app">
        @yield('content')
        @include('_partials.landing.footer')
    </div>

    <!-- JS Scripts -->
    <script src="{{ asset('js/jquery-3.2.1.js') }}"></script>
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
    <script src="{{ asset('js/popper.min.js') }}"></script>
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


    <script type="x-template" id="todo-component">
        <div>
            <h3>Example todo component</h3>
            <div v-for="item in items" class="form-group" :class="{'has-success': item.completed}">
                <div class="input-group">
                    <div class="input-group-addon">
                        <input type="checkbox" v-model="item.completed">
                    </div>
                    <input type="text" v-model="item.title" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" v-model="newItem" class="form-control">
                    <div class="input-group-btn">
                        <button class="btn" :class="{'btn-primary': newItem}" @click="addItem()">add!</button>
                    </div>
                </div>
            </div>
        </div>
    </script>
    <script>
        Vue.component('todo-component', {
            template: '#todo-component',
            data: function () {
                return {
                    items: [
                        {
                            id: 'item-1',
                            title: 'Checkout vue',
                            completed: false
                        }, {
                            id: 'item-2',
                            title: 'Use this stuff!!',
                            completed: false
                        }
                    ],
                    newItem: ''

                };
            },
            methods: {
                addItem: function () {
                    if (this.newItem) {
                        var item = {
                            id: Math.random(0, 10000),
                            title: this.newItem,
                            completed: false
                        };

                        this.items.push(item);
                        this.newItem = '';
                    }
                }
            }
        });

        var app = new Vue({
            el: '#vue-app'
        });
    </script>

<style>
    .registration-login-form{
        padding-left: 0;
        border-radius: 0;
        min-height: 200px;
    }
</style>

</body>
</html>