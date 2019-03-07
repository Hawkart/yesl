@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
                <gamer-profile-add></gamer-profile-add>
            </div>

            @include('lk._menu')
        </div>
    </div>
@endsection
