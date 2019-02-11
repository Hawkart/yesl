@extends('layouts.dashboard')

@section('content')
    @include('universities._partials.top')

    <div class="container">
        <div class="row">
            <div class="col col-xl-6 order-xl-2 col-lg-12 order-lg-1 col-sm-12 col-12">

                <div class="ui-block-title">
                    <h2 class="title">Vacancies in teams</h2>

                    @if(Auth::user()->id==$group->owner_id)
                        <a href="/universities/{{$group->slug}}/vacancies/create" class="btn btn-primary btn-sm btn-right float-right mt-1">Add vacancy</a>
                    @endif
                </div>

                @if(count($vacancies)>0)
                    @foreach($vacancies as $vacancy)
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="ui-block">
                                    <div class="ui-block-title">
                                        <h6 class="title">{{$vacancy['game']->title}}</h6>
                                    </div>

                                    <ul class="notification-list friend-requests">
                                    @foreach($vacancy['data'] as $v)
                                        <li>
                                            <div class="notification-event pl-0">
                                                <strong>Game role:</strong> {{$v->game_role}}, <strong>Ranking:</strong> {{$v->ranking}}
                                            </div>
                                            <div class="notification-icon" style="margin-top: -7px;">
                                                <chat-dialog-button :participant='{{json_encode($group->owner->toArray()) }}' :classes="'pa-0 full-width mb-0'">
                                                    <button type="submit" class="btn btn-sm btn-primary mt-0">Apply</button>
                                                </chat-dialog-button>
                                            </div>
                                        </li>
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            @include('universities._partials.left')
            @include('universities._partials.right')
        </div>
    </div>
@endsection
