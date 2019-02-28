<!-- Fixed Sidebar Left -->
<div class="fixed-sidebar">
    <div class="fixed-sidebar-left sidebar--small" id="sidebar-left">

        <a href="{{route('home')}}" class="logo">
            <div class="img-wrap">
                <img src="/img/logo.png" alt="{{env('APP_NAME', '')}}">
            </div>
        </a>

        @php
            $menus = [
                [
                    'title' => 'OPEN MENU',
                    'url' => '#',
                    'svg' => 'olymp-menu-icon',
                    'xlink' => '/svg-icons/sprites/icons.svg#olymp-menu-icon',
                    'li_class' => 'js-sidebar-open'
                ],
                [
                    'title' => 'SELECT COLLEGE/UNIVERSITY',
                    'url' => route('universities'),
                    'svg' => 'olymp-newsfeed-icon',
                    'xlink' => '/svg-icons/sprites/Universities.svg',
                    'li_class' => ''
                ],
                [
                    'title' => 'READ NEWSFEED',
                    'url' => '/feeds',
                    'svg' => 'olymp-newsfeed-icon',
                    'xlink' => '/svg-icons/sprites/NewsFeed.svg',
                    'li_class' => ''
                ],
                [
                    'title' => 'MAKE A POST',
                    'url' => '/users/'.Auth::user()->nickname,
                    'svg' => 'MyPage',
                    'xlink' => '/svg-icons/sprites/MyPage.svg',
                    'li_class' => ''
                ],
                [
                    'title' => 'FIND FRIENDS',
                    'url' => route('friends'),
                    'svg' => 'olymp-newsfeed-icon',
                    'xlink' => '/svg-icons/sprites/Friends.svg',
                    'li_class' => ''
                ],
                [
                    'title' => 'SEND MESSAGE',
                    'url' => '/im',
                    'svg' => 'olymp-chat---messages-icon',
                    'xlink' => '/svg-icons/sprites/Messages.svg',
                    'li_class' => ''
                ],
                [
                    'title' => 'CREATE GROUP',
                    'url' => route('groups'),
                    'svg' => 'olymp-happy-faces-icon',
                    'xlink' => '/svg-icons/sprites/Groups.svg',
                    'li_class' => ''
                ],

                [
                    'title' => 'GAMES',
                    'url' => route('games'),
                    'svg' => 'olymp-newsfeed-icon',
                    'xlink' => '/svg-icons/sprites/Games.svg',
                    'li_class' => ''
                ]/*,
                [
                    'title' => 'TEAMS',
                    'url' => '#',
                    'svg' => 'olymp-newsfeed-icon',
                    'xlink' => '/svg-icons/sprites/Teams.svg',
                    'li_class' => ''
                ],
                [
                    'title' => 'TOURNAMENTS',
                    'url' => '#',
                    'svg' => 'olymp-newsfeed-icon',
                    'xlink' => '/svg-icons/sprites/Tournaments.svg',
                    'li_class' => ''
                ],
                [
                    'title' => 'Financial Aid',
                    'url' => '#',
                    'svg' => 'olymp-newsfeed-icon',
                    'xlink' => '/svg-icons/sprites/Donations.svg',
                    'li_class' => ''
                ],*/
            ];

            $pendingFriendsCount = Auth::user()->getPendingIncomingFriends(0)->count();
            $unreadMessageCount = Auth::user()->unreadMessagesCount(); //newThreadsCount();
        @endphp

        <div class="mCustomScrollbar" data-mcs-theme="dark">
            <ul class="left-menu">
                @foreach($menus as $key=>$menu)
                    <li>
                        @if($key==0)
                            <a href="#" class="js-sidebar-open">
                                <svg class="olymp-menu-icon left-menu-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-menu-icon" data-toggle="tooltip" data-placement="right"   data-original-title="{{$menu['title']}}"></use></svg>
                            </a>
                        @else
                        <a href="{{$menu['url']}}" class="{{$menu['li_class']}}">
                            <!--<svg class="{{$menu['svg']}} left-menu-icon"  data-toggle="tooltip" data-placement="right"   data-original-title="{{$menu['title']}}">
                                <use xlink:href="{{$menu['xlink']}}"></use>
                            </svg>-->
                            <img src="{{$menu['xlink']}}" data-toggle="tooltip" data-placement="right"   data-original-title="{{$menu['title']}}" style="width: 24px; height: 24px;">
                            @if($menu['url']==route('friends') && $pendingFriendsCount>0)
                                <span class="label-avatar bg-primary">{{$pendingFriendsCount}}</span>
                            @endif

                            @if($menu['url']=='/im' && $unreadMessageCount>0)
                                <span class="label-avatar bg-purple">{{$unreadMessageCount}}</span>
                            @endif
                        </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1">
        <a href="/" class="logo">
            <div class="img-wrap">
                <img src="/img/logo.png" alt="{{env('APP_NAME', '')}}">
            </div>
            <div class="title-block">
                <h6 class="logo-title">{{env('APP_NAME', '')}}</h6>
            </div>
        </a>

        <div class="mCustomScrollbar" data-mcs-theme="dark">
            <ul class="left-menu">
                @foreach($menus as $key=>$menu)
                    <li>
                        @if($key==0)
                            <a href="#" class="js-sidebar-open">
                                <svg class="olymp-close-icon left-menu-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-close-icon"></use></svg>
                                <span class="left-menu-title">Collapse Menu</span>
                            </a>
                        @else
                            <a href="{{$menu['url']}}" class="{{$menu['li_class']}}">
                                <img src="{{$menu['xlink']}}" data-toggle="tooltip" data-placement="right"   data-original-title="{{$menu['title']}}" style="width: 24px; height: 24px;">
                                <span class="left-menu-title">{{ ucfirst(strtolower($menu['title'])) }}</span>
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>

            {{--
            <div class="profile-completion">

                <div class="skills-item">
                    <div class="skills-item-info">
                        <span class="skills-item-title">Profile Completion</span>
                        <span class="skills-item-count"><span class="count-animate" data-speed="1000" data-refresh-interval="50" data-to="76" data-from="0"></span><span class="units">76%</span></span>
                    </div>
                    <div class="skills-item-meter">
                        <span class="skills-item-meter-active bg-primary" style="width: 76%"></span>
                    </div>
                </div>

                <span>Complete <a href="#">your profile</a> so people can know more about you!</span>
            </div>
            --}}
        </div>
    </div>
</div>

<div class="fixed-sidebar fixed-sidebar-responsive">

    <div class="fixed-sidebar-left sidebar--small" id="sidebar-left-responsive">
        <a href="#" class="logo js-sidebar-open">
            <svg class="olymp-menu-icon left-menu-icon" style="fill: #fff;">
                <use xlink:href="/svg-icons/sprites/icons.svg#olymp-menu-icon" data-toggle="tooltip" data-placement="right" data-original-title="{{$menu['title']}}"></use>
            </svg>
        </a>
    </div>

    <div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1-responsive">
        <a href="#" class="js-sidebar-open logo" style="position: absolute; right: 20px;">
            <svg class="olymp-close-icon left-menu-icon" style="fill: #fff;">
                <use xlink:href="/svg-icons/sprites/icons.svg#olymp-close-icon"></use>
            </svg>
        </a>
        <a href="#" class="logo">
            <div class="img-wrap">
                <img src="/img/logo.png" alt="{{env('APP_NAME', '')}}">
            </div>
            <div class="title-block">
                <h6 class="logo-title">{{env('APP_NAME', '')}}</h6>
            </div>
        </a>
        <div class="mCustomScrollbar" data-mcs-theme="dark">
            <div class="ui-block-title ui-block-title-small">
                <h6 class="title">MAIN SECTIONS</h6>
            </div>

            <ul class="left-menu pt-0">
                @foreach($menus as $key=>$menu)
                    <li>
                        @if($key>0)
                            <a href="{{$menu['url']}}">
                                <img src="{{$menu['xlink']}}" style="width: 24px; height: 24px;">
                                <span class="left-menu-title">{{ ucfirst(strtolower($menu['title'])) }}</span>
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>

            <div class="ui-block-title ui-block-title-small">
                <h6 class="title">YOUR ACCOUNT</h6>
            </div>

            <ul class="left-menu pt-0">
                <li>
                    <a href="{{route('settings.games_profiles')}}">
                        <i class="fas fa-gamepad"  style="margin-right: 15px; width: 20px; height: 20px;"></i>
                        <span class="left-menu-title">Gamer Profiles</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('settings')}}">
                        <i class="far fa-user-circle"  style="margin-right: 15px; width: 20px; height: 20px;"></i>
                        <span class="left-menu-title">Resume</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('settings.password')}}">
                        <i class="fas fa-cog"  style="margin-right: 15px; width: 20px; height: 20px;"></i>
                        <span class="left-menu-title">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"  style="margin-right: 15px; width: 20px; height: 20px;"></i>
                        <span class="left-menu-title">Log Out</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>

            <div class="ui-block-title ui-block-title-small">
                <h6 class="title">About</h6>
            </div>

            <ul class="left-menu pt-0">
                <li>
                    <chat-dialog-button :participant='{{json_encode(\App\Models\User::where('id', getenv('ADMIN_SUPPORT_ID', 16))->first()->toArray()) }}' :group_id = "0" :classes="'text-left'">
                        <i class="far fa-life-ring" style="margin-right: 10px; width: 20px; height: 20px;"></i>
                        <span class="left-menu-title">Support</span>
                    </chat-dialog-button>
                </li>
            </ul>

        </div>
    </div>
</div>



<div class="fixed-sidebar right fixed-sidebar-responsive">
    <div class="fixed-sidebar-right sidebar--small" id="sidebar-right-responsive">
        <a href="{{route('settings')}}" class="olympus-chat logo">
            <div class="author-thumb">
                <img alt="author" src="{{ Storage::disk('public')->url(Auth::user()->avatar) }}" alt="{{Auth::user()->name}}" style="width: 40px; height: 40px " class="avatar">
                <span class="icon-status online"></span>
            </div>
        </a>
    </div>
</div>
