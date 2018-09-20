@extends('layouts.dashboard')

@section('content')

<div class="container">
    <div class="row">
        <div class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
            <div class="ui-block responsive-flex">
                <div class="ui-block-title">
                    <div class="h6 title">Groups ({{$groups->total()}})</div>
                    <form class="w-search">
                        <div class="form-group with-button">
                            <input class="form-control" type="text" placeholder="Search Groups...">
                            <button>
                                <svg class="olymp-magnifying-glass-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-magnifying-glass-icon"></use></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            @if($groups->count())
                <div class="row">
                    @foreach($groups as $group)

                        <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="ui-block">

                                <div class="friend-item" data-mh="choose-item">
                                    <div class="friend-header-thumb">
                                        <img src="{{ Storage::disk('public')->url($group->cover) }}" alt="cover image">
                                    </div>

                                    <div class="friend-item-content">

                                        <div class="more">
                                            <svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>
                                            <ul class="more-dropdown">
                                                <li>
                                                    <a href="#">Report Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#">Block Profile</a>
                                                </li>
                                                <li>
                                                    <a href="#">Turn Off Notifications</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="friend-avatar">
                                            <div class="author-thumb">
                                                <img src="{{ Storage::disk('public')->url($group->image) }}" alt="group logo">
                                            </div>
                                            <div class="author-content">
                                                <a href="{!! route('group', ['slug' => $group->slug]) !!}" class="h5 author-name" title="{{$group->title}}">
                                                    {{ str_limit($group->title, 50, '...') }}
                                                </a>
                                                <div class="country">
                                                    @if($group->groupable instanceof \App\Models\University)
                                                        The college
                                                    @elseif($group->groupable instanceof \App\Models\Game)
                                                        The game
                                                    @else

                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        @if($group->users()->count()>0)
                                        <ul class="friends-harmonic">

                                            @foreach($group->users as $user)
                                                <li>
                                                    <a href="#">
                                                        <img src="{{ Storage::disk('public')->url($user->avatar) }}" alt="friend">
                                                    </a>
                                                </li>
                                            @endforeach;

                                            @if(count($group->users)>8)
                                                <li>
                                                    <a href="#" class="all-users bg-blue">+{{count($group->users)-8}}</a>
                                                </li>
                                            @endif;
                                        </ul>
                                        @else

                                            <div class="friend-count">
                                                <a href="{!! route('group', ['slug' => $group->slug]) !!}" class="friend-count-item">
                                                    <div class="h6">{{$group->users()->count()}}</div>
                                                    <div class="title">Members</div>
                                                </a>
                                            </div>
                                        @endif

                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <nav aria-label="Page navigation">
                           {{ $groups->links() }}
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection