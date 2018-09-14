@extends('layouts.dashboard')

@section('content')

<div class="container">
    <div class="row">
        <div class="col col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
            <div class="ui-block">
                <div class="ui-block-title">
                    <h6 class="title">Change Password</h6>
                </div>
                <div class="ui-block-content">
                    <change-password-component url="/users/password"></change-password-component>
                </div>
            </div>
        </div>

        @include('lk._menu')
    </div>
</div>
@endsection

