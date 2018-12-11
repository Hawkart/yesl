@extends('layouts.dashboard')

@section('content')

<section class="blog-post-wrap">
    <div class="container">

        <div class="row">
            <div class="col col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">

                <div class="ui-block responsive-flex">
                    <div class="ui-block-title">
                        <div class="h6 title">My Groups ({{$groups->total()}})</div>
                        <form class="w-search">
                            <div class="form-group with-button">
                                <input class="form-control" name="q" type="text" placeholder="Search Groups..." value="{{ app('request')->input('q') }}">
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
                            <div class="col col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                <div class="ui-block">
                                    <article class="hentry blog-post university-article" data-mh="choose-item-2">
                                        <div class="post-thumb" data-mh="choose-item">
                                            <a href="{!! route('group', ['slug' => $group->slug]) !!}">
                                                <img src="{{  $group->image ? Storage::disk('public')->url($group->image) : '/img/author-main1.jpg' }}" alt="cover image">
                                            </a>
                                        </div>

                                        <div class="post-content">

                                            <div class="inline-items">
                                                <div>
                                                    @if($group->groupable instanceof \App\Models\University)
                                                        <a href="#" class="post-category bg-blue-light">The college</a>
                                                    @elseif($group->groupable instanceof \App\Models\Game)
                                                        <a href="#" class="post-category bg-primary">The game</a>
                                                    @else
                                                        <a href="#" class="post-category bg-purple">The college's game</a>
                                                    @endif
                                                </div>

                                                <div class="comments-shared" style="float:right; margin-top: 4px">
                                                    @if($group->groupable instanceof \App\Models\University)
                                                        <i class="fas fa-users"></i> {{ intval($group->groupable->enrollment_all) }}
                                                    @else
                                                        <i class="fas fa-users"></i> {{$group->users()->count()}}
                                                    @endif
                                                </div>
                                            </div>

                                            <a href="{!! route('group', ['slug' => $group->slug]) !!}" class="h4 post-title" title="{{$group->title}}">
                                                {{ str_limit($group->title, 50, '...') }}
                                            </a>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <nav aria-label="Page navigation">
                                {{ $groups->appends(request()->input())->links() }}
                            </nav>
                        </div>
                    </div>
                @endif
            </div>

            @include('groups._menu')
        </div>
    </div>
</section>
@endsection