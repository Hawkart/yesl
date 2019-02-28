<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
    <div class="ui-block">
        <div class="your-profile">
            <div id="accordion" role="tablist" aria-multiselectable="true">
                <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                        <h6 class="mb-0">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Nav
                                <svg class="olymp-dropdown-arrow-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-dropdown-arrow-icon"></use></svg>
                            </a>
                        </h6>
                    </div>

                    @php
                        $requestInCount = Auth::user()->getPendingIncomingFriends(0)->count();
                    @endphp

                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                        <ul class="your-profile-menu">
                            <li>
                                <a href="{{route('friends')}}">My friends</a>
                            </li>
                            <li>
                                <a href="{{route('friends.requests.in')}}">Friend requests</a>
                                <ul class="pl-xxl-4">
                                    <li>
                                        <a href="{{route('friends.requests.in')}}">Incoming
                                            @if($requestInCount>0)
                                                <span class="items-round-little bg-breez inline-block float-right">{{$requestInCount}}</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('friends.requests.out')}}">Outgoing</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="active">
                                <a href="{{route('friends.find')}}">Friend search</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <friend-possible-widget/>
</div>
