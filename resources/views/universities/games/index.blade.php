@extends('layouts.dashboard')

@section('content')
    @include('universities._partials.top')

    <div class="container">
        <div class="row">
            <div class="col-xl-6 order-xl-2 col-lg-12 order-lg-3 order-md-3 order-sm-3 order-3 col-sm-12 col-12">
                <university-games
                    :user="{{json_encode(Auth::user()->toArray())}}"
                    :group="{{json_encode($group->toArray())}}"
                    :university="{{json_encode($group->groupable->toArray())}}"
                    :teams="{{json_encode($games->toArray())}}"
                ></university-games>
            </div>
            @include('universities._partials.left')
            @include('universities._partials.right')
        </div>
    </div>

    <university-game-add></university-game-add>
@endsection
