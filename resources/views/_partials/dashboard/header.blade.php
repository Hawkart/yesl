<!-- Header-BP -->
<header class="header" id="site-header">

    <div class="page-title">
        <h6>{{SEO::getTitle($session = false)}}</h6>
    </div>

    <div class="header-content-wrapper">

        <form class="search-bar w-search notification-list friend-requests">
            <div class="form-group with-button">
                <input class="form-control js-user-search" placeholder="Search here people or pages..." type="text">
                <button>
                    <svg class="olymp-magnifying-glass-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-magnifying-glass-icon"></use></svg>
                </button>
            </div>
        </form>

        <div class="control-block">
            @php
                $unreadMessageCount = Auth::user()->unreadMessagesCount();
                $requestInCount = Auth::user()->getPendingIncomingFriends(0)->count();
            @endphp

            <div class="control-icon more has-items">

                <!--<chat-notify-icon :user="{{json_encode(Auth::user()->toArray())}}"></chat-notify-icon>-->

                <a href="/im"><img src="/svg-icons/sprites/Message_top.svg" style="width: 28px; height: 28px;"></a>
                @if($unreadMessageCount>0)
                    <div class="label-avatar bg-purple">{{$unreadMessageCount}}</div>
                @endif

            </div>


            <div class="control-icon more has-items">
                <img src="/svg-icons/sprites/Notifications.svg" style="width: 28px; height: 28px;">
                @if($requestInCount>0)
                    <div class="label-avatar bg-primary">{{$requestInCount}}</div>
                @endif
            </div>

            <div class="author-page author vcard inline-items more">
                <div class="author-thumb">
                    <img alt="author" src="{{ Storage::disk('public')->url(Auth::user()->avatar) }}" alt="{{Auth::user()->name}}" width="36px" class="avatar">
                    <span class="icon-status online"></span>

                    <div class="more-dropdown more-with-triangle">
                        <div class="mCustomScrollbar" data-mcs-theme="dark">
                            <div class="ui-block-title ui-block-title-small">
                                <h6 class="title">Your Account</h6>
                            </div>

                            <ul class="account-settings">
                                <li>
                                    <a href="{{route('settings')}}">
                                        <svg class="olymp-menu-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-menu-icon"></use></svg>
                                        <span>Profile Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/users/{{Auth::user()->nickname}}">
                                        <img src="/svg-icons/sprites/MyPage.svg" style="margin-right: 15px; width: 20px; height: 20px;">
                                        <span>My page</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <svg class="olymp-logout-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-logout-icon"></use></svg>
                                        <span>Log Out</span>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>

                            <div class="ui-block-title ui-block-title-small">
                                <h6 class="title">About</h6>
                            </div>

                            <ul>
                                <li>
                                    <chat-dialog-button :participant='{{json_encode(\App\Models\User::where('id', getenv('ADMIN_SUPPORT_ID', 16))->first()->toArray()) }}' :group_id = "0" :classes="'pa-0 mb-0 text-left'">
                                        <span>Support</span>
                                    </chat-dialog-button>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                <a href="{{route('settings')}}" class="author-name fn">
                    <div class="author-title">
                        {{Auth::user()->name}} <svg class="olymp-dropdown-arrow-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-dropdown-arrow-icon"></use></svg>
                    </div>
                </a>
            </div>

        </div>
    </div>

</header>


<header class="header header-responsive" id="site-header-responsive">

    <div class="header-content-wrapper">
        <ul class="nav nav-tabs mobile-app-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#chat" role="tab">
                    <div class="control-icon has-items">
                        <chat-notify-icon :user="{{json_encode(Auth::user()->toArray())}}"></chat-notify-icon>
                    </div>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#notification" role="tab">
                    <div class="control-icon has-items">
                        <img src="/svg-icons/sprites/Notifications.svg" style="width: 28px; height: 28px;">
                        @if($requestInCount>0)
                            <div class="label-avatar bg-primary">{{$requestInCount}}</div>
                        @endif
                    </div>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('settings')}}" class="nav-link">
                    <div class="author-thumb control-icon has-items">
                        <img alt="author" src="{{ Storage::disk('public')->url(Auth::user()->avatar) }}" alt="{{Auth::user()->name}}" style="width: 40px; height: 40px " class="avatar">
                        <span class="icon-status online"></span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</header>

<!-- ... end Responsive Header-BP -->
<div class="header-spacer"></div>
