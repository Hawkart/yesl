@extends('layouts.dashboard')

@section('content')
    @include('universities._partials.top')

    <div class="container">
        <div class="row">
            <div class="col-xl-6 order-xl-2 col-lg-12 order-lg-3 order-md-3 order-sm-3 order-3 col-sm-12 col-12">
                <university-vacancies
                    :user="{{json_encode(Auth::user()->toArray())}}"
                    :group="{{json_encode($group->toArray())}}"
                    :university="{{json_encode($group->groupable->toArray())}}"
                    :vacancies="{{json_encode($vacancies)}}"
                ></university-vacancies>
            </div>
            @include('universities._partials.left')
            @include('universities._partials.right')
        </div>
    </div>

    <university-vacancy-add :games="{{json_encode($group->groupable->games->toArray())}}"></university-vacancy-add>
@endsection
