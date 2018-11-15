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
                    'title' => 'MY PAGE',
                    'url' => '/users/'.Auth::user()->nickname,
                    'svg' => 'MyPage',
                    'xlink' => '/svg-icons/sprites/MyPage.svg',
                    'li_class' => ''
                ],
                [
                    'title' => 'NEWSFEED',
                    'url' => '/',
                    'svg' => 'olymp-newsfeed-icon',
                    'xlink' => '/svg-icons/sprites/NewsFeed.svg',
                    'li_class' => ''
                ],
                [
                    'title' => 'MESSAGES',
                    'url' => '/im',
                    'svg' => 'olymp-chat---messages-icon',
                    'xlink' => '/svg-icons/sprites/Messages.svg',
                    'li_class' => ''
                ],
                [
                    'title' => 'GROUPS',
                    'url' => route('groups'),
                    'svg' => 'olymp-happy-faces-icon',
                    'xlink' => '/svg-icons/sprites/Groups.svg',
                    'li_class' => ''
                ],
                [
                    'title' => 'FRIENDS',
                    'url' => route('friends'),
                    'svg' => 'olymp-newsfeed-icon',
                    'xlink' => '/svg-icons/sprites/Friends.svg',
                    'li_class' => ''
                ],
                [
                    'title' => 'UNIVERSITIES',
                    'url' => route('universities'),
                    'svg' => 'olymp-newsfeed-icon',
                    'xlink' => '/svg-icons/sprites/Universities.svg',
                    'li_class' => ''
                ],
                [
                    'title' => 'GAMES',
                    'url' => route('games'),
                    'svg' => 'olymp-newsfeed-icon',
                    'xlink' => '/svg-icons/sprites/Games.svg',
                    'li_class' => ''
                ],
                [
                    'title' => 'TEAMS',
                    'url' => '/',
                    'svg' => 'olymp-newsfeed-icon',
                    'xlink' => '/svg-icons/sprites/Teams.svg',
                    'li_class' => ''
                ],
                [
                    'title' => 'TOURNAMENTS',
                    'url' => '/',
                    'svg' => 'olymp-newsfeed-icon',
                    'xlink' => '/svg-icons/sprites/Tournaments.svg',
                    'li_class' => ''
                ],
                [
                    'title' => 'Financial Aid',
                    'url' => '/',
                    'svg' => 'olymp-newsfeed-icon',
                    'xlink' => '/svg-icons/sprites/Donations.svg',
                    'li_class' => ''
                ],
            ];

            $pendingFriendsCount = Auth::user()->getPendingIncomingFriends(0)->count();
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
            <img src="/img/logo.png" alt="{{env('APP_NAME', '')}}">
        </a>
    </div>

    <div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1-responsive">
        <a href="#" class="logo">
            <div class="img-wrap">
                <img src="/img/logo.png" alt="{{env('APP_NAME', '')}}">
            </div>
            <div class="title-block">
                <h6 class="logo-title">{{env('APP_NAME', '')}}</h6>
            </div>
        </a>

        <div class="mCustomScrollbar" data-mcs-theme="dark">

            <div class="control-block">
                <div class="author-page author vcard inline-items">
                    <div class="author-thumb">
                        <img alt="author" src="{{ Storage::disk('public')->url(Auth::user()->avatar) }}" alt="{{Auth::user()->name}}" width="36px" class="avatar">
                        <span class="icon-status online"></span>
                    </div>
                    <a href="{{route('settings')}}" class="author-name fn">
                        <div class="author-title">
                            {{Auth::user()->name}} <svg class="olymp-dropdown-arrow-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-dropdown-arrow-icon"></use></svg>
                        </div>
                        <span class="author-subtitle">SPACE COWBOY</span>
                    </a>
                </div>
            </div>

            <div class="ui-block-title ui-block-title-small">
                <h6 class="title">MAIN SECTIONS</h6>
            </div>

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
                                <svg class="{{$menu['svg']}} left-menu-icon"  data-toggle="tooltip" data-placement="right"   data-original-title="{{$menu['title']}}">
                                    <use xlink:href="{{$menu['xlink']}}"></use>
                                </svg>
                                <span class="left-menu-title">{{ ucfirst(strtolower($menu['title'])) }}</span>
                            </a>
                        @endif;
                    </li>
                @endforeach
            </ul>

            <div class="ui-block-title ui-block-title-small">
                <h6 class="title">YOUR ACCOUNT</h6>
            </div>

            <ul class="account-settings">
                <li>
                    <a href="#">
                        <svg class="olymp-menu-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-menu-icon"></use></svg>
                        <span>Profile Settings</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg class="olymp-star-icon left-menu-icon"  data-toggle="tooltip" data-placement="right"   data-original-title="FAV PAGE"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-star-icon"></use></svg>
                        <span>Create Fav Page</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg class="olymp-logout-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-logout-icon"></use></svg>
                        <span>Log Out</span>
                    </a>
                </li>
            </ul>

            <div class="ui-block-title ui-block-title-small">
                <h6 class="title">About Olympus</h6>
            </div>

            <ul class="about-olympus">
                <li>
                    <a href="#">
                        <span>Terms and Conditions</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span>FAQs</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span>Careers</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span>Contact</span>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>

<!-- ... end Fixed Sidebar Left -->

{{--
<div class="fixed-sidebar right">
    <div class="fixed-sidebar-right sidebar--small" id="sidebar-right">

        <div class="mCustomScrollbar" data-mcs-theme="dark">
            <ul class="chat-users">
                <li class="inline-items js-chat-open">
                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar67-sm.jpg" class="avatar">
                        <span class="icon-status online"></span>
                    </div>
                </li>
                <li class="inline-items js-chat-open">
                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar62-sm.jpg" class="avatar">
                        <span class="icon-status online"></span>
                    </div>
                </li>

                <li class="inline-items js-chat-open">
                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar68-sm.jpg" class="avatar">
                        <span class="icon-status online"></span>
                    </div>
                </li>

                <li class="inline-items js-chat-open">
                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar69-sm.jpg" class="avatar">
                        <span class="icon-status away"></span>
                    </div>
                </li>

                <li class="inline-items js-chat-open">
                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar70-sm.jpg" class="avatar">
                        <span class="icon-status disconected"></span>
                    </div>
                </li>
                <li class="inline-items js-chat-open">
                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar64-sm.jpg" class="avatar">
                        <span class="icon-status online"></span>
                    </div>
                </li>
                <li class="inline-items js-chat-open">
                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar71-sm.jpg" class="avatar">
                        <span class="icon-status online"></span>
                    </div>
                </li>
                <li class="inline-items js-chat-open">
                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar72-sm.jpg" class="avatar">
                        <span class="icon-status away"></span>
                    </div>
                </li>
                <li class="inline-items js-chat-open">
                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar63-sm.jpg" class="avatar">
                        <span class="icon-status status-invisible"></span>
                    </div>
                </li>
                <li class="inline-items js-chat-open">
                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar72-sm.jpg" class="avatar">
                        <span class="icon-status away"></span>
                    </div>
                </li>
                <li class="inline-items js-chat-open">

                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar71-sm.jpg" class="avatar">
                        <span class="icon-status online"></span>
                    </div>
                </li>
            </ul>
        </div>

        <div class="search-friend inline-items">
            <a href="#" class="js-sidebar-open">
                <svg class="olymp-menu-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-menu-icon"></use></svg>
            </a>
        </div>

        <a href="#" class="olympus-chat inline-items js-chat-open">
            <svg class="olymp-chat---messages-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-chat---messages-icon"></use></svg>
        </a>

    </div>

    <div class="fixed-sidebar-right sidebar--large" id="sidebar-right-1">

        <div class="mCustomScrollbar" data-mcs-theme="dark">

            <div class="ui-block-title ui-block-title-small">
                <a href="#" class="title">Close Friends</a>
                <a href="#">Settings</a>
            </div>

            <ul class="chat-users">
                <li class="inline-items js-chat-open">

                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar67-sm.jpg" class="avatar">
                        <span class="icon-status online"></span>
                    </div>

                    <div class="author-status">
                        <a href="#" class="h6 author-name">Carol Summers</a>
                        <span class="status">ONLINE</span>
                    </div>

                    <div class="more"><svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>

                        <ul class="more-icons">
                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="START CONVERSATION" class="olymp-comments-post-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-comments-post-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="ADD TO CONVERSATION" class="olymp-add-to-conversation-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-add-to-conversation-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="BLOCK FROM CHAT" class="olymp-block-from-chat-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-block-from-chat-icon"></use></svg>
                            </li>
                        </ul>

                    </div>

                </li>
                <li class="inline-items js-chat-open">

                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar62-sm.jpg" class="avatar">
                        <span class="icon-status online"></span>
                    </div>

                    <div class="author-status">
                        <a href="#" class="h6 author-name">Mathilda Brinker</a>
                        <span class="status">AT WORK!</span>
                    </div>

                    <div class="more"><svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>

                        <ul class="more-icons">
                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="START CONVERSATION" class="olymp-comments-post-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-comments-post-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="ADD TO CONVERSATION" class="olymp-add-to-conversation-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-add-to-conversation-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="BLOCK FROM CHAT" class="olymp-block-from-chat-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-block-from-chat-icon"></use></svg>
                            </li>
                        </ul>

                    </div>

                </li>

                <li class="inline-items js-chat-open">


                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar68-sm.jpg" class="avatar">
                        <span class="icon-status online"></span>
                    </div>

                    <div class="author-status">
                        <a href="#" class="h6 author-name">Carol Summers</a>
                        <span class="status">ONLINE</span>
                    </div>

                    <div class="more"><svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>

                        <ul class="more-icons">
                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="START CONVERSATION" class="olymp-comments-post-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-comments-post-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="ADD TO CONVERSATION" class="olymp-add-to-conversation-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-add-to-conversation-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="BLOCK FROM CHAT" class="olymp-block-from-chat-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-block-from-chat-icon"></use></svg>
                            </li>
                        </ul>

                    </div>


                </li>

                <li class="inline-items js-chat-open">


                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar69-sm.jpg" class="avatar">
                        <span class="icon-status away"></span>
                    </div>

                    <div class="author-status">
                        <a href="#" class="h6 author-name">Michael Maximoff</a>
                        <span class="status">AWAY</span>
                    </div>

                    <div class="more"><svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>

                        <ul class="more-icons">
                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="START CONVERSATION" class="olymp-comments-post-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-comments-post-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="ADD TO CONVERSATION" class="olymp-add-to-conversation-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-add-to-conversation-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="BLOCK FROM CHAT" class="olymp-block-from-chat-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-block-from-chat-icon"></use></svg>
                            </li>
                        </ul>

                    </div>


                </li>

                <li class="inline-items js-chat-open">


                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar70-sm.jpg" class="avatar">
                        <span class="icon-status disconected"></span>
                    </div>

                    <div class="author-status">
                        <a href="#" class="h6 author-name">Rachel Howlett</a>
                        <span class="status">OFFLINE</span>
                    </div>

                    <div class="more"><svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>

                        <ul class="more-icons">
                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="START CONVERSATION" class="olymp-comments-post-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-comments-post-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="ADD TO CONVERSATION" class="olymp-add-to-conversation-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-add-to-conversation-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="BLOCK FROM CHAT" class="olymp-block-from-chat-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-block-from-chat-icon"></use></svg>
                            </li>
                        </ul>

                    </div>


                </li>
            </ul>


            <div class="ui-block-title ui-block-title-small">
                <a href="#" class="title">MY FAMILY</a>
                <a href="#">Settings</a>
            </div>

            <ul class="chat-users">
                <li class="inline-items js-chat-open">

                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar64-sm.jpg" class="avatar">
                        <span class="icon-status online"></span>
                    </div>

                    <div class="author-status">
                        <a href="#" class="h6 author-name">Sarah Hetfield</a>
                        <span class="status">ONLINE</span>
                    </div>

                    <div class="more"><svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>

                        <ul class="more-icons">
                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="START CONVERSATION" class="olymp-comments-post-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-comments-post-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="ADD TO CONVERSATION" class="olymp-add-to-conversation-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-add-to-conversation-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="BLOCK FROM CHAT" class="olymp-block-from-chat-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-block-from-chat-icon"></use></svg>
                            </li>
                        </ul>

                    </div>
                </li>
            </ul>


            <div class="ui-block-title ui-block-title-small">
                <a href="#" class="title">UNCATEGORIZED</a>
                <a href="#">Settings</a>
            </div>

            <ul class="chat-users">
                <li class="inline-items js-chat-open">

                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar71-sm.jpg" class="avatar">
                        <span class="icon-status online"></span>
                    </div>

                    <div class="author-status">
                        <a href="#" class="h6 author-name">Bruce Peterson</a>
                        <span class="status">ONLINE</span>
                    </div>

                    <div class="more"><svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>

                        <ul class="more-icons">
                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="START CONVERSATION" class="olymp-comments-post-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-comments-post-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="ADD TO CONVERSATION" class="olymp-add-to-conversation-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-add-to-conversation-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="BLOCK FROM CHAT" class="olymp-block-from-chat-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-block-from-chat-icon"></use></svg>
                            </li>
                        </ul>

                    </div>


                </li>
                <li class="inline-items js-chat-open">

                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar72-sm.jpg" class="avatar">
                        <span class="icon-status away"></span>
                    </div>

                    <div class="author-status">
                        <a href="#" class="h6 author-name">Chris Greyson</a>
                        <span class="status">AWAY</span>
                    </div>

                    <div class="more"><svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>

                        <ul class="more-icons">
                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="START CONVERSATION" class="olymp-comments-post-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-comments-post-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="ADD TO CONVERSATION" class="olymp-add-to-conversation-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-add-to-conversation-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="BLOCK FROM CHAT" class="olymp-block-from-chat-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-block-from-chat-icon"></use></svg>
                            </li>
                        </ul>

                    </div>

                </li>
                <li class="inline-items js-chat-open">

                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar63-sm.jpg" class="avatar">
                        <span class="icon-status status-invisible"></span>
                    </div>

                    <div class="author-status">
                        <a href="#" class="h6 author-name">Nicholas Grisom</a>
                        <span class="status">INVISIBLE</span>
                    </div>

                    <div class="more"><svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>

                        <ul class="more-icons">
                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="START CONVERSATION" class="olymp-comments-post-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-comments-post-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="ADD TO CONVERSATION" class="olymp-add-to-conversation-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-add-to-conversation-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="BLOCK FROM CHAT" class="olymp-block-from-chat-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-block-from-chat-icon"></use></svg>
                            </li>
                        </ul>

                    </div>
                </li>
                <li class="inline-items js-chat-open">

                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar72-sm.jpg" class="avatar">
                        <span class="icon-status away"></span>
                    </div>

                    <div class="author-status">
                        <a href="#" class="h6 author-name">Chris Greyson</a>
                        <span class="status">AWAY</span>
                    </div>

                    <div class="more"><svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>

                        <ul class="more-icons">
                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="START CONVERSATION" class="olymp-comments-post-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-comments-post-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="ADD TO CONVERSATION" class="olymp-add-to-conversation-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-add-to-conversation-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="BLOCK FROM CHAT" class="olymp-block-from-chat-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-block-from-chat-icon"></use></svg>
                            </li>
                        </ul>

                    </div>
                </li>
                <li class="inline-items js-chat-open">

                    <div class="author-thumb">
                        <img alt="author" src="/img/avatar71-sm.jpg" class="avatar">
                        <span class="icon-status online"></span>
                    </div>

                    <div class="author-status">
                        <a href="#" class="h6 author-name">Bruce Peterson</a>
                        <span class="status">ONLINE</span>
                    </div>

                    <div class="more"><svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>

                        <ul class="more-icons">
                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="START CONVERSATION" class="olymp-comments-post-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-comments-post-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="ADD TO CONVERSATION" class="olymp-add-to-conversation-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-add-to-conversation-icon"></use></svg>
                            </li>

                            <li>
                                <svg data-toggle="tooltip" data-placement="top" data-original-title="BLOCK FROM CHAT" class="olymp-block-from-chat-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-block-from-chat-icon"></use></svg>
                            </li>
                        </ul>

                    </div>
                </li>
            </ul>

        </div>

        <div class="search-friend inline-items">
            <form class="form-group" >
                <input class="form-control" placeholder="Search Friends..." value="" type="text">
            </form>

            <a href="29-YourAccount-AccountSettings.html" class="settings">
                <svg class="olymp-settings-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-settings-icon"></use></svg>
            </a>

            <a href="#" class="js-sidebar-open">
                <svg class="olymp-close-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-close-icon"></use></svg>
            </a>
        </div>

        <a href="#" class="olympus-chat inline-items js-chat-open">

            <h6 class="olympus-chat-title">OLYMPUS CHAT</h6>
            <svg class="olymp-chat---messages-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-chat---messages-icon"></use></svg>
        </a>

    </div>
</div>

<!-- ... end Fixed Sidebar Right -->


<!-- Fixed Sidebar Right-Responsive -->

<div class="fixed-sidebar right fixed-sidebar-responsive">

    <div class="fixed-sidebar-right sidebar--small" id="sidebar-right-responsive">

        <a href="#" class="olympus-chat inline-items js-chat-open">
            <svg class="olymp-chat---messages-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-chat---messages-icon"></use></svg>
        </a>

    </div>

</div>
--}}