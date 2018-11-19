@extends('layouts.app')

@section('content')

    <div class="row display-flex">
        <div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="landing-content">
                <h1>Are you looking for Esports scholarship ?</h1>
                <h3>Here you will find the offers for Esports athletes gathered from more than 100 universities.</h3>
                <p>
                    Esports athletes are the privileged persons in US colleges.<br/>
                    Everything is being done to make you play as well as you possibly can.<br/>
                    Your academic schedule is well-planned around your Esports schedule.
                </p>
                <p>Do you have an account?</p>
                <p><a href="{{ route('login') }}" class="btn btn-md btn-border c-white">{{ __('Login') }} Now!</a></p>
            </div>
        </div>

        <div class="col col-xl-5 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="registration-login-form">

                <div class="title h6">{{ __('Register') }}</div>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}" class="content">
                    @csrf

                    <div class="row">
                        <div class="col col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group label-floating {{ old('first_name') ? ' ' : 'is-empty' }}">
                                <label class="control-label">First Name</label>
                                <input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required>

                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group label-floating {{ old('last_name') ? ' ' : 'is-empty' }}">
                                <label class="control-label">Last Name</label>
                                <input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required>

                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group label-floating {{ old('email') ? ' ' : 'is-empty' }}">
                                <label class="control-label">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group label-floating is-empty">
                                <label class="control-label">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group date-time-picker label-floating">
                                <label class="control-label">Your Birthday</label>
                                <input class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="date_birth" value="{{ old('date_birth') }}" required/>
                                <span class="input-group-addon">
                                    <svg class="olymp-calendar-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-calendar-icon"></use></svg>
                                </span>

                                @if ($errors->has('date_birth'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_birth') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group label-floating is-select">
                                <label class="control-label">Your Gender</label>
                                <select class="selectpicker form-control" name="gender">
                                    <option value="0">Male</option>
                                    <option value="1">Female</option>
                                </select>
                            </div>

                            <div class="form-group label-floating remember">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="terms" id="terms" {{ old('terms') ? 'checked' : '' }}>
                                        I accept the <a href="{{ route('terms') }}">Terms and Conditions</a> of the website
                                    </label>
                                </div>
                                @if ($errors->has('terms'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('terms') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg full-width">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
