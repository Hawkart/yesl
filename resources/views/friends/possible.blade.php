@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">

            @include('friends._menu')

            <div class="col col-xl-9 col-lg-9 col-md-6 col-sm-12 col-12">
                <friend-possible-search></friend-possible-search>
            </div>
        </div>
    </div>
@endsection