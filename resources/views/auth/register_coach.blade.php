@extends('layouts.app')

@section('content')

    <div class="row display-flex">
        <div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="landing-content">
                <h1>Are you looking for Esports scholarship ?</h1>
                <h3>Here you will find all the offers for Esports athletes gathered from more than 100 universities.</h3>
                <p>
                    Esports athletes are the privileged persons in US colleges.<br/>
                    Everything will be done to make you play as well as you possibly can.<br/>
                    Your academic schedule will be planned around your Esports schedule.
                </p>
                <p>Do you have an account?</p>
                <p><a href="{{ route('login') }}" class="btn btn-md btn-border c-white">{{ __('Login') }} Now!</a></p>
            </div>
        </div>

        <div class="col col-xl-5 col-lg-6 col-md-12 col-sm-12 col-12">
            <register-coach></register-coach>
        </div>
    </div>
@endsection