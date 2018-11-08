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
                                <img src="{{ $user->overlay ? Storage::disk('public')->url($user->overlay) : "/img/top-header2.jpg" }}" alt="{{$user->name}}">
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
                                        <!--<li>
                                            <a href="12-FavouritePage.html" class="active">Timeline</a>
                                        </li>-->
                                        <li>
                                            <a href="13-FavouritePage-About.html">About</a>
                                        </li>
                                        <li>
                                            <a href="07-ProfilePage-Photos.html">Groups</a>
                                        </li>
                                        <li>
                                            <a href="09-ProfilePage-Videos.html">Friends</a>
                                        </li>
                                        <li>
                                            <a href="14-FavouritePage-Statistics.html">Teams</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="control-block-button">
                                <!--<a href="35-YourAccount-FriendsRequests.html" class="btn btn-control bg-blue">
                                    <svg class="olymp-happy-face-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-happy-face-icon"></use></svg>
                                </a>-->

                                @if($user->id!=Auth::user()->id)
                                    <chat-dialog-button :participant='{{json_encode($user->toArray()) }}'></chat-dialog-button>
                                @endif

                                @if($user->id==Auth::user()->id)
                                    <div class="btn btn-control bg-primary more">
                                        <svg class="olymp-settings-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-settings-icon"></use></svg>

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
            <div class="col col-xl-6 order-xl-2 col-lg-12 order-lg-1 col-sm-12 col-12">

                @if($user->id==Auth::user()->id)
                    <div class="ui-block">
                        <post-form :group="[]" :user="{{json_encode(Auth::user()->toArray())}}"></post-form>
                    </div>
                @endif

                <post-list :group="[]" :user="{{json_encode(Auth::user()->toArray())}}" type="wall"></post-list>
            </div>
            <div class="col col-xl-3 order-xl-1 col-lg-6 order-lg-2 col-md-6 col-sm-12 col-12">

            </div>

            <div class="col col-xl-3 order-xl-3 col-lg-6 order-lg-3 col-md-6 col-sm-12 col-12">

            </div>
        </div>
    </div>
@endsection