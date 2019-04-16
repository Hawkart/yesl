@extends('layouts.dashboard')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="ui-block">

                    <div class="top-header top-header-favorit">
                        <div class="top-header-thumb">

                            @if($group->owner_id==Auth::user()->id)
                                <overlay-upload uimg="{{ $group->cover ? Storage::disk('public')->url($group->cover) : '/img/university-overlay-default.jpg' }}" uploadapi="/groups/{{$group->id}}/cover" dataname="cover"></overlay-upload>
                            @else
                                <div class="top-header-overlay">
                                    <img src="{{ $group->cover ? Storage::disk('public')->url($group->cover) : '/img/university-overlay-default.jpg' }}" alt="{{$group->title}}">
                                </div>
                            @endif

                            <div class="top-header-author" @if($group->owner_id==Auth::user()->id) style="z-index: 22;" @endif>

                                @if($group->owner_id==Auth::user()->id)
                                    <avatar-upload dataname="image" uimg="{{ $group->image ? Storage::disk('public')->url($group->image) : '/img/university-logo-default.jpg' }}" uploadapi="/groups/{{$group->id}}/logo"></avatar-upload>
                                @else
                                    <div class="author-thumb">
                                        <img src="{{ $group->image ? Storage::disk('public')->url($group->image) : '/img/university-logo-default.jpg' }}" alt="{{$group->title}}">
                                    </div>
                                @endif

                                <div class="author-content">
                                    <a href="#" class="h3 author-name">{{$group->title}}</a>
                                </div>
                            </div>
                        </div>
                        <div class="profile-section">
                            <div class="row">
                                <div class="col-xl-3 m-auto col-lg-3 col-xs-12">
                                </div>
                                <div class="col-xl-6 m-auto col-lg-6 col-xs-12">
                                </div>
                                <div class="col-xl-3 m-auto col-lg-3 col-xs-12">
                                    <group-subscribe :group_id = "{{$group->id}}" :user_id="{{Auth::id()}}"></group-subscribe>
                                </div>
                            </div>

                            <div class="control-block-button">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6 order-xl-2 col-lg-12 order-lg-1 col-sm-12 col-12">
                @if($can_post)
                    <div class="ui-block">
                        <post-form :group="{{json_encode($group->toArray())}}" :user="{{json_encode(Auth::user()->toArray())}}"></post-form>
                    </div>
                @endif

                @if($group->status!=1)
                    <div class="alert alert-danger" role="alert">
                        After moderation, your group will be activated.
                    </div>
                @endif

                <post-list :group="{{json_encode($group->toArray())}}" :user="{{json_encode(Auth::user()->toArray())}}" type="group"></post-list>
            </div>
            <div class="col-xl-3 order-xl-1 col-lg-6 order-lg-2 col-md-6 col-sm-12 col-12">
                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title">Description</h6>
                    </div>
                    <div class="ui-block-content">
                        {{$group->description}}
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
            </div>
        </div>
    </div>
@endsection
