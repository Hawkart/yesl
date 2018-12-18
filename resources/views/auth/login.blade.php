@extends('layouts.app')

@section('content')

    <div class="row display-flex">
        <div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="landing-content">
                @include('auth._partials.welcome_text')
                <a href="{{ route('register') }}" class="btn btn-md btn-border c-white mb-0 mr-lg-3">Register as Athlete</a>
                <a href="{{ route('register_coach') }}" class="btn btn-md btn-border c-white">Register as Coach</a>
            </div>
        </div>

        <div class="col col-xl-5 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="registration-login-form">

                <!--<ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="{{route('login')}}" role="tab">
                            {{ __('Login') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="{{ route('register') }}" role="tab">
                            {{ __('Register') }}
                        </a>
                    </li>
                </ul>-->

                <div class="title h6">{{ __('Login') }}</div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}" class="content">
                    @csrf
                    <div class="row">
                        <div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group label-floating {{ old('email') ? ' ' : 'is-empty' }}">
                                <label class="control-label">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autocomplete="off" autocapitalize="off" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group label-floating is-empty">
                                <label class="control-label">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" autocomplete="off" autocapitalize="off" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="remember">

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                                <a class="forgot" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>

                            <button type="submit" class="btn btn-lg btn-primary full-width">
                                {{ __('Login') }}
                            </button>

                            <!--<div class="or"></div>

                            <a href="#" class="btn btn-lg bg-facebook full-width btn-icon-left"><i class="fab fa-facebook-f" aria-hidden="true"></i>Login with Facebook</a>

                            <a href="#" class="btn btn-lg bg-twitter full-width btn-icon-left"><i class="fab fa-twitter" aria-hidden="true"></i>Login with Twitter</a>
                            --><p>Don’t you have an account? <a href="{{ route('register') }}">Register Now!</a> it’s really simple and you can start enjoing all the benefits!</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
