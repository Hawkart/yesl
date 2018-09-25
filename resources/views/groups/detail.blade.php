@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-xl-6 order-xl-2 col-lg-12 order-lg-1 col-sm-12 col-12">

            </div>
            <div class="col col-xl-3 order-xl-1 col-lg-6 order-lg-2 col-md-6 col-sm-12 col-12">
                <div class="ui-block">
                    <div class="post-thumb">
                        <img src="{{ Storage::disk('public')->url($group->image) }}" alt="cover image">
                    </div>
                    <div class="ui-block-content">

                        <h6 class="title">{{$group->title}}</h6>
                        <!-- W-Personal-Info -->

                        <ul class="widget w-personal-info item-block">
                            <li>
                                <span class="text">We are Rock Band from Los Angeles, now based in San Francisco, come and listen to us play!</span>
                            </li>
                            <li>
                                <span class="title">Created:</span>
                                <span class="text">September 17th, 2013</span>
                            </li>
                            <li>
                                <span class="title">Based in:</span>
                                <span class="text">San Francisco, California</span>
                            </li>
                            <li>
                                <span class="title">Contact:</span>
                                <a href="#" class="text">greengoo_gigs@youmail.com</a>
                            </li>
                            <li>
                                <span class="title">Website:</span>
                                <a href="#" class="text">www.ggrock.com</a>
                            </li>
                            <li>
                                <span class="title">Favourites:</span>
                                <a href="#" class="text">5630 </a>
                            </li>
                        </ul>

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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection