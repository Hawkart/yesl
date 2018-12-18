@extends('layouts.app')

@section('content')
    <div class="row display-flex">
        <div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="landing-content">
                @include('auth._partials.welcome_text')
                <p>Do you have an account?</p>
                <p><a href="{{ route('login') }}" class="btn btn-md btn-border c-white">{{ __('Login') }} Now!</a></p>
            </div>
        </div>

        <div class="col col-xl-5 col-lg-6 col-md-12 col-sm-12 col-12">
            <register-athlete></register-athlete>
        </div>
    </div>
@endsection
