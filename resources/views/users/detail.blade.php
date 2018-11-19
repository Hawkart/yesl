@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="ui-block">
                    <div class="top-header top-header-favorit">
                        <div class="top-header-thumb">
                            @if($user->id==Auth::user()->id)
                                <overlay-upload :user='{{json_encode($user->toArray()) }}'></overlay-upload>
                            @else
                                <div class="top-header-overlay">
                                    <img src="{{ $user->overlay ? Storage::disk('public')->url($user->overlay) : "/img/top-header2.jpg" }}" alt="{{$user->name}}">
                                </div>
                            @endif
                            <div class="top-header-author">
                                @if($user->id==Auth::user()->id)
                                    <avatar-upload :user='{{json_encode($user->toArray()) }}'></avatar-upload>
                                @else
                                    <div class="author-thumb">
                                        <img src="{{ Storage::disk('public')->url($user->avatar) }}" alt="{{$user->name}}">
                                    </div>
                                @endif
                                <div class="author-content">
                                    <a href="#" class="h3 author-name">{{$user->name}}</a>
                                    <div class="country">{{$user->description}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-section">
                            <div class="row">
                                <div class="col col-xl-8 m-auto col-lg-8 col-md-12">
                                    <ul class="profile-menu">
                                        <li>
                                            <a href="#">About</a>
                                        </li>
                                        <li>
                                            <a href="#">Groups ({{$groups->total()}})</a>
                                        </li>
                                        <li>
                                            <a href="#">Friends ({{$friends->total()}})</a>
                                        </li>
                                        <li>
                                            <a href="#">Teams</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="control-block-button">
                                <!--<a href="35-YourAccount-FriendsRequests.html" class="btn btn-control bg-blue">
                                    <svg class="olymp-happy-face-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-happy-face-icon"></use></svg>
                                </a>-->

                                @if($user->id!=Auth::user()->id)
                                    <chat-dialog-button :participant='{{json_encode($user->toArray()) }}' :classes="'btn-control bg-purple'">
                                        <img src="/svg-icons/sprites/Message_top.svg" style="width: 28px; height: 28px; margin-bottom: 5px;">
                                    </chat-dialog-button>
                                @endif

                                @if($user->id==Auth::user()->id)
                                    <div class="btn btn-control bg-primary more">
                                        <img src="/svg-icons/sprites/Teams_enjoy.svg" style="width: 28px; height: 28px; margin-bottom: 5px;">

                                        <ul class="more-dropdown more-with-triangle triangle-bottom-right">
                                            <li>
                                                <a href="{{route('settings.personal')}}">Account Settings</a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                @if($groups->total()>0)
                    <div class="ui-block">
                        <div class="ui-block-title">
                            <h6 class="title">Your Groups ({{count($groups)}})</h6>
                        </div>
                        <div class="ui-block-content">
                            <ul class="widget w-faved-page">
                                @foreach($groups as $group)
                                    <li>
                                        @if($group->groupable instanceof \App\Models\University)
                                            <a href="{!! route('university', ['slug' => $group->slug]) !!}">
                                                <img src="{{ $group->image ? Storage::disk('public')->url($group->image) : '/img/university-logo-default.jpg' }}" title="{{$group->title}}">
                                            </a>
                                        @elseif($group->groupable instanceof \App\Models\Game)
                                            <a href="{!! route('game', ['slug' => $group->slug]) !!}">
                                                <img src="{{ Storage::disk('public')->url($group->image) }}" title="{{$group->title}}">
                                            </a>
                                        @else
                                            <a href="{!! route('group', ['slug' => $group->slug]) !!}">
                                                <img src="{{ Storage::disk('public')->url($group->image) }}" title="{{$group->title}}">
                                            </a>
                                        @endif


                                    </li>
                                @endforeach

                                @if($groups->total()>$groups->perPage())
                                    <li class="all-users">
                                        <a href="#">+{{$groups->total()-$groups->perPage()}}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col col-xl-6 col-lg-12 col-sm-12 col-12">

                @if($user->id==Auth::user()->id)
                    <div class="ui-block">
                        <post-form :group="[]" :user="{{json_encode($user->toArray())}}"></post-form>
                    </div>
                @endif

                <post-list :group="[]" :user="{{json_encode($user->toArray())}}" type="wall"></post-list>
            </div>


            <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                @if($friends->total()>0)
                    <div class="ui-block">
                        <div class="ui-block-title">
                            <h6 class="title">Your Friends ({{$friends->total()}})</h6>
                        </div>
                        <div class="ui-block-content">
                            <ul class="widget w-faved-page">
                                @foreach($friends as $friend)
                                    <li>
                                        <a href="/users/{{$friend->nickname}}">
                                            <img src="{{ Storage::disk('public')->url($friend->avatar) }}" title="{{$friend->name}}">
                                        </a>
                                    </li>
                                @endforeach
                                @if($friends->total()>$friends->perPage())
                                    <li class="all-users">
                                        <a href="#">+{{$friends->total()-$friends->perPage()}}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif

                @if(count($mutual)>0)
                    <div class="ui-block">
                        <div class="ui-block-title">
                            <h6 class="title">Mutual Friends ({{count($mutual)}})</h6>
                        </div>
                        <div class="ui-block-content">
                            <ul class="widget w-faved-page">
                                @foreach($mutual as $friend)
                                    <li>
                                        <a href="/users/{{$friend->nickname}}">
                                            <img src="{{ Storage::disk('public')->url($friend->avatar) }}" title="{{$friend->name}}">
                                        </a>
                                    </li>
                                @endforeach
                                @if(count($mutual)>8)
                                    <li class="all-users">
                                        <a href="#">+{{count($mutual)-8}}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection