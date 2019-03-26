<div class="col-xl-3 order-xl-3 col-lg-6 order-lg-1 col-md-12 order-md-1 order-sm-1 order-1 col-sm-12 col-12">

    @if(!empty($group->groupable->es_team_image) || ((strpos($group->owner->email, '@campusteam.tv')!==false && !empty($group->coach_email)) || strpos($group->owner->email, '@campusteam.tv')===false))
        <div class="ui-block">
            @if(!empty($group->groupable->es_team_image))
                <div class="post-thumb mb-0" style="max-height: 300px">
                    <img src="{{ Storage::disk('public')->url($group->groupable->es_team_image) }}" alt="{{$group->groupable->es_team_title}}">
                </div>
            @endif
            <div class="ui-block-content">
                @php
                    $countProfiles = Auth::user()->profiles()->count();
                @endphp

                @if(Auth::user()->checkUniversityApplicationsExists($group->groupable->id))
                    <p class="text-danger text-center">You've applied already</p>
                @endif

                @if((strpos($group->owner->email, '@campusteam.tv')!==false && !empty($group->coach_email)) || strpos($group->owner->email, '@campusteam.tv')===false)

                    @if($countProfiles>0)
                        <chat-dialog-button :participant='{{json_encode($group->owner->toArray()) }}' :group_id = "{{$group->id}}" :classes="'pa-0 full-width mb-0'">
                            <button type="submit" class="btn bg-violet btn-xs full-width mt-0">Write Message to a Coach</button>
                        </chat-dialog-button>
                    @else
                        <a href="#" data-toggle="modal" data-target="#warning-profile" class="btn bg-violet btn-xs full-width mt-0">Write Message to the Coach</a>
                    @endif
                @endif

                @if(strpos($group->owner->email, '@campusteam.tv')===false)
                    @if($countProfiles>0 && !empty(Auth::user()->description))
                        <a href="/universities/{{$group->slug}}/teams" class="btn btn-success btn-xs full-width mt-lg-1 mb-0 btn-apply" id="apply-team-ga">Apply to the Team</a>
                    @else
                        <a href="#" data-toggle="modal" data-target="#warning-resume-profile" class="btn btn-success btn-xs full-width mt-lg-1 mb-0 btn-apply" id="apply-team-ga">Apply to the Team</a>
                    @endif
                @endif
            <!--<button type="submit" class="btn btn-success btn-xs full-width mt-lg-1 mb-0" id="apply-team-ga">APPLY TO THE TEAM</button>-->
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
        </div>
    </div>

    {{--
    @if(count($twitts)>0 && strpos($group->owner->email, '@campusteam.tv')===false)
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
    --}}

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

    @if(isset($similar_groups) && count($similar_groups)>0)
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
