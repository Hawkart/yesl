@extends('layouts.app')

@section('content')
    <div class="row display-flex pb-lg-5">
        <div class="col-centered col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <register-athlete></register-athlete>
            <div class="landing-content">
                <p>Do you have an account? &nbsp; &nbsp;<a href="{{ route('login') }}" class="btn btn-md btn-border c-white">{{ __('Login') }} Now!</a></p>
            </div>
        </div>
    </div>
@endsection
