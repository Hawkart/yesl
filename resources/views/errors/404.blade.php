@extends('layouts.app')

@section('content')
<section class="medium-padding120">
    <div class="container">
        <div class="row">
            <div class="col col-xl-6 m-auto col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="page-404-content c-white">
                    <img src="/img/404.png" alt="photo">
                    <div class="crumina-module crumina-heading align-center">
                        <h2 class="h1 heading-title c-white">A <span class="c-white">wild ghost</span> appears! Sadly, not what you were looking for...</h2>
                        <p class="heading-text">Sorry! The page you were looking for has been moved or doesn’t exist.
                            If you like, you can return to our homepage, or if the problem persists, send us an email to: <a href="mailto:support@campusteam.tv" target="_blank" class="c-white">support@campusteam.tv</a>
                        </p>
                    </div>

                    <a href="/" class="btn btn-blue btn-lg">Go to Homepage</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
