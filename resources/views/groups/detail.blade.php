@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-6 order-xl-2 col-lg-12 order-lg-1 col-sm-12 col-12">
                @if($can_post)
                    <div class="ui-block">
                        <post-form :group="{{json_encode($group->toArray())}}" :user="{{json_encode(Auth::user()->toArray())}}"></post-form>
                    </div>
                @endif

                <post-list :group="{{json_encode($group->toArray())}}" :user="{{json_encode(Auth::user()->toArray())}}" type="group"></post-list>
            </div>
            <div class="col-xl-3 order-xl-1 col-lg-6 order-lg-2 col-md-6 col-sm-12 col-12">
                <div class="ui-block">
                    <div class="post-thumb mb-0" style="height: 300px">
                        <img src="{{  $group->image ? Storage::disk('public')->url($group->image) : '/img/author-main1.jpg'  }}" alt="{{$group->title}}">
                    </div>
                    <div class="ui-block-content">

                        <h6 class="title">{{$group->title}}</h6>

                        @if($group->groupable instanceof \App\Models\University)
                            <a href="#" class="post-category bg-blue-light mb-xxl-1">The college</a>

                            @if(!empty($group->groupable->location_lat))
                                <pin-popup-google-map :university="{{json_encode($group->groupable->toArray())}}"></pin-popup-google-map>
                            @endif

                            <ul class="widget w-personal-info item-block">
                                <li>
                                    <span class="title">Address:</span>
                                    <span class="text">{{$group->groupable->address}}</span>
                                </li>
                                <li>
                                    <span class="title">Website:</span>
                                    <a href="//{{$group->groupable->url}}" target="_blank" class="text">{{$group->groupable->url}}</a>
                                </li>
                            </ul>
                        @elseif($group->groupable instanceof \App\Models\Game)
                            <a href="#" class="post-category bg-primary">The game</a>

                            <ul class="widget w-personal-info item-bloc mb-xxl-1k">
                                <li>
                                    <span class="text">{{$group->groupable->body}}</span>
                                </li>
                                <li>
                                    <span class="title">Genre:</span>
                                    <span class="text">{{$group->groupable->genre->title}}</span>
                                </li>
                            </ul>
                        @else
                            <a href="#" class="post-category bg-purple">The college's game</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-3 order-xl-3 col-lg-6 order-lg-3 col-md-6 col-sm-12 col-12">
                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title">Members ({{$group->users()->count()}})</h6>
                    </div>
                    <div class="ui-block-content">
                        <ul class="widget w-faved-page">
                            @if($group->users()->count()>0)

                                @foreach($group->users as $user)
                                    <li>
                                        <a href="#">
                                            <img src="{{ Storage::disk('public')->url($user->avatar) }}" title="{{$user->name}}">
                                        </a>
                                    </li>
                                @endforeach

                                @if(count($group->users)>8)
                                    <li class="all-users">
                                        <a href="#">+{{count($group->users)-8}}</a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                        <group-subscribe :group_id = "{{$group->id}}" :user_id="{{Auth::id()}}"></group-subscribe>
                    </div>
                </div>

                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title">Administrators</h6>
                    </div>
                    <div class="ui-block-content">
                        <ul class="widget w-friend-pages-added notification-list friend-requests">
                            <li class="inline-items pa-0 border-0">
                                <div>
                                    <img src="{{ Storage::disk('public')->url($group->owner->avatar) }}" alt="{{$group->owner->name}}" width="44">
                                </div>
                                <div class="notification-event mt-lg-3">
                                    <a href="{!! route('user', ['slug' => $group->owner->nickname]) !!}" class="h6 notification-friend">{{$group->owner->name}}</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                @if(count($similar_groups)>0)
                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title">Similar groups</h6>
                    </div>

                    <ul class="widget w-friend-pages-added notification-list friend-requests">
                        @foreach($similar_groups as $sgroup)
                        <li class="inline-items">
                            <div>
                                <img src="{{ Storage::disk('public')->url($sgroup->image) }}" alt="{{$sgroup->title}}" width="36">
                            </div>
                            <div class="notification-event mt-lg-3">
                                <a href="{!! route('group', ['slug' => $sgroup->slug]) !!}" class="h6 notification-friend">{{$sgroup->title}}</a>
                                <!--<span class="chat-message-item">{{$group->groupable->body}}</span>-->
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

            </div>
        </div>
    </div>
@endsection
