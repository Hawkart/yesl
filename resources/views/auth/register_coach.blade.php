@extends('layouts.app')

@section('content')
    <div class="row display-flex">
        <!--<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="landing-content">
                <p>Do you have an account?</p>
                <p><a href="{{ route('login') }}" class="btn btn-md btn-border c-white">{{ __('Login') }} Now!</a></p>
            </div>
        </div>-->

        <div class="col-centered col-xl-5 col-lg-6 col-md-12 col-sm-6 col-12">
            <register-coach></register-coach>
            <div class="landing-content">
                <p>Do you have an account? &nbsp;&nbsp;<a href="{{ route('login') }}" class="btn btn-md btn-border c-white">{{ __('Login') }} Now!</a></p>
            </div>
        </div>
    </div>
@endsection
