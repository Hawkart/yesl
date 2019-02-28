@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title">Edit game's profile</h6>
                    </div>
                    <div class="ui-block-content">
                        <profiles-edit-component :profile='{{json_encode($profile->toArray()) }}' url="/profiles/{{$profile->id}}"></profiles-edit-component>
                    </div>
                </div>
            </div>

            @include('lk._menu')
        </div>
    </div>

    <profiles-add-component></profiles-add-component>
@endsection
