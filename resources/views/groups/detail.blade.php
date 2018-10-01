@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-xl-6 order-xl-2 col-lg-12 order-lg-1 col-sm-12 col-12">
                <div class="ui-block">
                    <post-form-component :group_id="{{$group->id}}" :user="{{json_encode(Auth::user()->toArray())}}"></post-form-component>
                </div>

                <post-list-component :group_id="{{$group->id}}"></post-list-component>
            </div>
            <div class="col col-xl-3 order-xl-1 col-lg-6 order-lg-2 col-md-6 col-sm-12 col-12">
                <div class="ui-block">
                    <div class="post-thumb mb-0" style="height: 300px">
                        <img src="{{ Storage::disk('public')->url($group->image) }}" alt="cover image">
                    </div>
                    <div class="ui-block-content">

                        <h6 class="title">{{$group->title}}</h6>

                        @if($group->groupable instanceof \App\Models\University)
                            <a href="#" class="post-category bg-blue-light">The college</a>

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

                            <ul class="widget w-personal-info item-block">
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

            <div class="col col-xl-3 order-xl-3 col-lg-6 order-lg-3 col-md-6 col-sm-12 col-12">
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
                        <button type="submit" class="btn btn-purple btn-xs full-width mt-lg-3 mb-0">
                            Subscribe
                        </button>
                    </div>
                </div>

                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title">Similar groups</h6>
                    </div>
                    <div class="ui-block-content">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection