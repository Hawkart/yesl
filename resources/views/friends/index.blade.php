@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">

            @include('friends._menu')

            <div class="col-xl-9 col-lg-9 col-md-6 col-sm-12 col-12">
                <friend-list></friend-list>
            </div>
        </div>
    </div>
@endsection
