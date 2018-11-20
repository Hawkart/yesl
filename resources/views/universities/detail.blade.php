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
                    <!--<div class="post-thumb mb-0" style="max-height: 300px">
                        <img src="{{ $group->image ? Storage::disk('public')->url($group->image) : '/img/author-main1.jpg' }}" alt="{{$group->title}}">
                    </div>-->
                        <div class="ui-block-title"><h6 class="title">Info</h6></div>
                    <div class="ui-block-content">
                        <!--<h5 class="title">{{$group->title}} <span class="verified"><i class="fa fa-check" aria-hidden="true" title="Verified"></i></span></h5>-->

                        <ul class="widget w-personal-info item-block">
                            <!--<li>
                                <span class="title">Address:</span>
                                <span class="text">{{$group->groupable->address}}
                                    @if(!empty($group->groupable->location_lat))
                                        <pin-popup-google-map :university="{{json_encode($group->groupable->toArray())}}"></pin-popup-google-map>
                                    @endif
                                </span>
                            </li>-->
                            @if(!empty($group->groupable->url))
                                <li>
                                    <span class="title">Website:</span>
                                    <a href="//{{$group->groupable->url}}" target="_blank" class="text">{{$group->groupable->url}}</a>
                                </li>
                            @endif
                            @if(!empty($group->groupable->price_calculator_url))
                                <li>
                                    <span class="title">Net price calculator:</span>
                                    <a href="//{{$group->groupable->price_calculator_url}}" target="_blank" class="text">{{$group->groupable->price_calculator_url}}</a>
                                </li>
                            @endif
                            
                            @if($group->groupable->ownership)
                                <li>
                                    <span class="title">Control of institution:</span>
                                    <span class="text">
                                        @if($group->groupable->ownership==1)
                                            Public
                                        @elseif($group->groupable->ownership==2)
                                            Private nonprofit
                                        @elseif($group->groupable->ownership==3)
                                            Private for-profit
                                        @endif
                                    </span>
                                </li>
                            @endif
                            @php
                                $fields = [
                                    'admission_rate_overall' =>  'Admission rate',
                                    'sat_scores_average_overall' =>  'Average SAT equivalent score of students admitted',
                                    'online_only' =>  'Flag for distance-education-only education',
                                    'size' =>  'Enrollment of undergraduate certificate/degree-seeking students',
                                    'enrollment_all' =>  'Enrollment of all undergraduate students',
                                    'operating' =>  'Currently operating institution',
                                    'cost_tuition_in_state' =>  'In-state tuition and fees',
                                    'cost_tuition_out_of_state' =>  'Out-of-state tuition and fees',
                                    'aid_pell_grant_rate' =>  'Percentage of undergraduates who receive a Pell Grant',
                                    'aid_federal_loan_rate' =>  'Percent of all undergraduate students receiving a federal student loan',
                                    'demographics_age_entry' =>  'Average age of entry',
                                    'demographics_female_share' =>  'Share of female students',
                                    'demographics_married' =>  'Share of married students',
                                    '10_yrs_after_entry_working_not_enrolled' =>  'Mean earnings of students working and not enrolled 10 years after entry',
                                    '10_yrs_after_entry_median' =>  'Median earnings of students working and not enrolled 10 years after entry',
                                    'demographics_men' =>  'Total share of enrollment of undergraduate degree-seeking students who are men',
                                    'demographics_women' =>  'Total share of enrollment of undergraduate degree-seeking students who are women',
                                    'undergrads_with_pell_grant' =>  'Number of undergraduate students (denominator percent receiving a pell grant or federal student loan)',
                                    'undergrads_non_degree' =>  'Number of non-degree-seeking undergraduate students',
                                    'grad_students' =>  'Number of graduate students'
                                ];
                            @endphp

                            @foreach($fields as $field=>$title)
                                @if($group->groupable->$field)
                                    <li>
                                        <span class="title">{{$title}}:</span>
                                        <span class="text">{{$group->groupable->$field}}</span>
                                    </li>
                                @endif
                            @endforeach

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
                            <button type="submit" class="btn btn-success btn-xs full-width mt-lg-1">APPLY TO THE TEAM</button>
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

                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title">Active Members</h6>
                    </div>
                    <div class="ui-block-content">
                        <ul class="widget w-faved-page">
                            <li>
                                <a href="#">
                                    <img src="/img/faved-page1.jpg" alt="user">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="/img/faved-page2.jpg" alt="user">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="/img/faved-page3.jpg" alt="user">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="/img/faved-page4.jpg" alt="user">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="/img/faved-page5.jpg" alt="user">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="/img/faved-page6.jpg" alt="user">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="/img/faved-page7.jpg" alt="user">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="/img/faved-page8.jpg" alt="user">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="/img/faved-page9.jpg" alt="user">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="/img/faved-page7.jpg" alt="user">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="/img/faved-page10.jpg" alt="user">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="/img/faved-page11.jpg" alt="user">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="/img/faved-page7.jpg" alt="user">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="/img/faved-page12.jpg" alt="user">
                                </a>
                            </li>
                            <li class="all-users">
                                <a href="#">+5k</a>
                            </li>
                        </ul>

                        <!-- ... end W-Faved-Page -->				</div>
                </div>

                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title">{{$group->groupable->title}}'s Poll</h6>
                    </div>
                    <div class="ui-block-content">
                        <!-- W-Pool -->

                        <ul class="widget w-pool">
                            <li>
                                <p>If you want to study in {{$group->groupable->title}} what Esport team would you join in ?</p>
                            </li>
                            <li>
                                <div class="skills-item">
                                    <div class="skills-item-info">
                                        <span class="skills-item-title">
                                            <span class="radio">
                                                <label>
                                                    <input type="radio" name="optionsRadios">
                                                    League Of Legend
                                                </label>
                                            </span>
                                        </span>
                                            <span class="skills-item-count">
                                            <span class="count-animate" data-speed="1000" data-refresh-interval="50" data-to="52" data-from="0"></span>
                                            <span class="units">52%</span>
                                        </span>
                                    </div>
                                    <div class="skills-item-meter">
                                        <span class="skills-item-meter-active bg-primary" style="width: 52%"></span>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="skills-item">
                                    <div class="skills-item-info">
                                        <span class="skills-item-title">
                                            <span class="radio">
                                                <label>
                                                    <input type="radio" name="optionsRadios">
                                                    Football
                                                </label>
                                            </span>
                                        </span>
                                            <span class="skills-item-count">
                                            <span class="count-animate" data-speed="1000" data-refresh-interval="50" data-to="27" data-from="0"></span>
                                            <span class="units">27%</span>
                                        </span>
                                    </div>
                                    <div class="skills-item-meter">
                                        <span class="skills-item-meter-active bg-primary" style="width: 27%"></span>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="skills-item">
                                    <div class="skills-item-info">
									<span class="skills-item-title">
										<span class="radio">
											<label>
												<input type="radio" name="optionsRadios">
												Warcraft
											</label>
										</span>
									</span>
                                        <span class="skills-item-count">
										<span class="count-animate" data-speed="1000" data-refresh-interval="50" data-to="11" data-from="0"></span>
										<span class="units">11%</span>
									</span>
                                    </div>
                                    <div class="skills-item-meter">
                                        <span class="skills-item-meter-active bg-primary" style="width: 11%"></span>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="skills-item">
                                    <div class="skills-item-info">
									<span class="skills-item-title">
										<span class="radio">
											<label>
												<input type="radio" name="optionsRadios">
												Dota2
											</label>
										</span>
									</span>
                                        <span class="skills-item-count">
										<span class="count-animate" data-speed="1000" data-refresh-interval="50" data-to="10" data-from="0"></span>
										<span class="units">10%</span>
									</span>
                                    </div>
                                    <div class="skills-item-meter">
                                        <span class="skills-item-meter-active bg-primary" style="width: 10%"></span>
                                    </div>
                                </div>
                            </li>
                        </ul>

                        <!-- .. end W-Pool -->
                        <a href="#" class="btn btn-md-2 btn-border-think custom-color c-grey full-width">Vote Now!</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection