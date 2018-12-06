@extends('layouts.dashboard')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="ui-block">

                    <div class="top-header top-header-favorit">
                        <div class="top-header-thumb">
                            <div class="top-header-overlay">
                                <img src="{{ $group->cover ? Storage::disk('public')->url($group->cover) : '/img/university-overlay-default.jpg' }}" alt="{{$group->title}}">
                            </div>
                            <div class="top-header-author">

                                <div class="author-thumb">
                                    <img src="{{ $group->image ? Storage::disk('public')->url($group->image) : '/img/university-logo-default.jpg' }}" alt="{{$group->title}}">
                                </div>

                                <div class="author-content">
                                    <a href="#" class="h3 author-name">{{$group->title}} <span class="verified"><i class="fa fa-check" aria-hidden="true" title="Verified"></i></span></a>
                                    <div class="country">
                                        <span class="title">Address:</span>
                                        <span class="text">{{$group->groupable->address}}
                                            @if(!empty($group->groupable->location_lat))
                                                <pin-popup-google-map :university="{{json_encode($group->groupable->toArray())}}"></pin-popup-google-map>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-section" style="padding: 30px 0">
                            <div class="control-block-button">

                            </div>
                        </div>
                    </div>

                    <!--
                    <div class="top-header top-header-favorit university-overlay" style="background-image: url({{ $group->cover ? Storage::disk('public')->url($group->cover) : '/img/top-header1.jpg' }})"></div>
                    -->
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col col-xl-6 order-xl-2 col-lg-12 order-lg-1 col-sm-12 col-12">
                @if($can_post)
                    <div class="ui-block">
                        <post-form :user="{{json_encode(Auth::user()->toArray())}}" :group="{{json_encode($group->toArray())}}"></post-form>
                    </div>
                @endif

                <post-list :user="{{json_encode(Auth::user()->toArray())}}" :group="{{json_encode($group->toArray())}}" type="group"></post-list>
            </div>
            <div class="col col-xl-3 order-xl-1 col-lg-6 order-lg-2 col-md-6 col-sm-12 col-12">
                <div class="ui-block">
                    <div class="ui-block-title"><h6 class="title">Info</h6></div>
                    <div class="ui-block-content">
                        <ul class="widget w-personal-info item-block">
                            <li>
                                <a href="#" class="btn btn-success btn-sm full-width" id="apply-university-ga" target="_blank">APPLY NOW</a>
                            </li>

                            @if(!empty($group->groupable->admission_rate_overall))
                                <li>
                                    <span class="text">Admission rate: <strong>{{$group->groupable->admission_rate_overall*100}}%</strong></span>
                                </li>
                            @endif

                            @if(!empty($group->groupable->sat_scores_average_overall))
                                <li>
                                    <span class="text">Average SAT equivalent score: <strong>{{$group->groupable->sat_scores_average_overall}}</strong></span>
                                </li>
                            @endif

                            @if(!empty($group->groupable->demographics_female_share))
                                <li>
                                    <span class="text">Female students: <strong>{{$group->groupable->demographics_female_share*100}}%</strong></span>
                                </li>
                            @endif

                            @if(!empty($group->groupable->demographics_married))
                                <li>
                                    <span class="text">Married students: <strong>{{$group->groupable->demographics_married*100}}%</strong></span>
                                </li>
                            @endif

                            @if(!empty($group->groupable->cost_tuition_in_state))
                                <li>
                                    <span class="text">In-state/ Out-of-state tuition and fees:
                                        <strong>${{number_format($group->groupable->cost_tuition_in_state)}}/${{number_format($group->groupable->cost_tuition_out_of_state)}}</strong>
                                    </span>
                                </li>
                            @endif

                            @if(!empty($group->groupable->price_calculator_url))
                                <li>
                                    <span class="text">
                                        <a href="//{{$group->groupable->price_calculator_url}}" target="_blank" class="btn btn-primary btn-sm full-width">Net Price Calculator</a>
                                    </span>
                                </li>
                            @endif

                            @if(!empty($group->groupable->aid_pell_grant_rate))
                                <li>
                                    <span class="text"><strong>{{$group->groupable->aid_pell_grant_rate*100}}%</strong> receive a Pell Grant</span>
                                </li>
                            @endif

                            @if(!empty($group->groupable->aid_federal_loan_rate))
                                <li>
                                    <span class="text"><strong>{{$group->groupable->aid_federal_loan_rate*100}}%</strong> receiving a student loan</span>
                                </li>
                            @endif

                            @if($group->groupable->ownership)
                                <li>
                                    <span class="text">
                                        <strong>
                                        @if($group->groupable->ownership==1)
                                            Public
                                        @elseif($group->groupable->ownership==2)
                                            Private nonprofit
                                        @elseif($group->groupable->ownership==3)
                                            Private for-profit
                                        @endif
                                        </strong>
                                            institution
                                    </span>
                                </li>
                            @endif

                            @if(!empty($group->groupable->demographics_age_entry))
                                <li>
                                    <span class="text">Average age of entry: <strong>{{$group->groupable->demographics_age_entry}}</strong></span>
                                </li>
                            @endif

                            @if(!empty($group->groupable->url))
                                <li>
                                    <a href="//{{$group->groupable->url}}" target="_blank" class="btn btn-success btn-sm full-width mb-0">Website</a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>

            <div class="col col-xl-3 order-xl-3 col-lg-6 order-lg-3 col-md-6 col-sm-12 col-12">

                @if(!empty($group->groupable->es_team_image))
                    <div class="ui-block">
                        <div class="post-thumb mb-0" style="max-height: 300px">
                            <img src="{{ Storage::disk('public')->url($group->groupable->es_team_image) }}" alt="{{$group->groupable->es_team_title}}">
                        </div>
                        <div class="ui-block-content">
                            <button type="submit" class="btn btn-primary btn-xs full-width mt-0">WRITE LETTER TO COACH</button>
                            <button type="submit" class="btn btn-success btn-xs full-width mt-lg-1 mb-0" id="apply-team-ga">APPLY TO THE TEAM</button>
                        </div>
                    </div>
                @endif

                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title">Members ({{$group->users()->count()}})</h6>
                    </div>
                    <div class="ui-block-content">
                        <ul class="widget w-faved-page">
                            @if($group->users()->count()>0)

                                @foreach($group->users as $user)
                                    <li>
                                        <a href="/users/{{$user->nickname}}">
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

                @if(count($twitts)>0)
                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title">Twitter Feed</h6>
                    </div>
                    <ul class="widget w-twitter">
                        @php
                            $twitterTitle = explode(',', $group->groupable->twitter_str)[0];
                        @endphp
                        @foreach($twitts as $twitt)
                        <li class="twitter-item">
                            <div class="author-folder">
                                <img src="{{ $group->groupable->es_team_image ? Storage::disk('public')->url($group->groupable->es_team_image) : '/img/twitter-avatar1.png' }}" width="40">
                                <div class="author">
                                    <a href="#" class="author-name">{{"@".$twitterTitle }}</a>
                                    <time class="group published">
                                        {{Carbon\Carbon::parse($twitt['created_at'])->diffForHumans()}}
                                    </time>
                                </div>
                            </div>
                            <p class="mb-0">{!!$twitt['text']!!}</p>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title">Administrators</h6>
                    </div>
                    <div class="ui-block-content">
                        <ul class="widget w-friend-pages-added notification-list friend-requests">
                            <li class="inline-items pa-0 border-0">
                                <div>
                                    <img src="{{ Storage::disk('public')->url($group->owner->avatar) }}" alt="{{$group->owner->name}}" width="40">
                                </div>
                                <div class="notification-event mt-lg-1">
                                    <a href="{!! route('user', ['slug' => $group->owner->nickname]) !!}" class="h6 notification-friend">Admin of {{$group->title}}</a>
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