@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-xl-6 order-xl-2 col-lg-12 order-lg-1 col-sm-12 col-12">
                <feed-list :user="{{json_encode(Auth::user()->toArray())}}"></feed-list>
            </div>

            @include('feeds._menu')

            <div class="col col-xl-3 order-xl-3 col-lg-6 order-lg-3 col-md-6 col-sm-12 col-12">

                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({
                        google_ad_client: "ca-pub-4709211777366339",
                        enable_page_level_ads: true
                    });
                </script>

                <friend-possible-widget/>
            </div>
        </div>
    </div>
@endsection