@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title">Personal Information</h6>
                    </div>
                    <div class="ui-block-content">

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="form-horizontal mt-10" method="POST" action="{{route('users.update')}}">
                            @csrf
                            {{ method_field('patch') }}

                            <div class="row">

                                <div class="col col-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">First Name</label>
                                        <input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ $user->first_name }}" required>

                                        @if ($errors->has('first_name'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col col-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Last Name</label>
                                        <input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ $user->last_name }}" required>

                                        @if ($errors->has('last_name'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col col-6 col-xl-6 col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">{{ __('E-Mail Address') }}</label>
                                        <input id="email" type="email" disabled="disabled" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col col-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nickname</label>
                                        <input type="text" class="form-control{{ $errors->has('nickname') ? ' is-invalid' : '' }}" name="nickname" value="{{ $user->nickname }}" required>

                                        @if ($errors->has('nickname'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nickname') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col col-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">

                                    <div class="form-group date-time-picker label-floating">
                                        <label class="control-label">Your Birthday</label>
                                        <datepicker name="date_birth" value="{{ $user->date_birth ? $user->date_birth->toDateString() : '' }}" format="yyyy-MM-dd" :required="true" :class="{{ $errors->has('date_birth') ? ' is-invalid' : '' }}"></datepicker>
                                        <span class="input-group-addon">
                                        <svg class="olymp-calendar-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-calendar-icon"></use></svg>
                                    </span>

                                        @if ($errors->has('date_birth'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('date_birth') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col col-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label">Your Gender</label>
                                        {{ Form::select('gender', [0 => 'Male', 1 => 'Female'], $user->gender, ['class' => 'selectpicker form-control']) }}
                                    </div>
                                </div>

                                <div class="col col-lg-12 col-md-6 col-sm-12 col-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Write a little description about you</label>
                                        <textarea name="description" class="form-control" placeholder="">{{$user->description}}</textarea>
                                    </div>
                                </div>

                                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                    <button class="btn btn-secondary btn-lg full-width">Restore all Attributes</button>
                                </div>
                                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                    <button class="btn btn-primary btn-lg full-width">Save all Changes</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @include('lk._menu')
        </div>
    </div>
@endsection