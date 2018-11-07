@extends('layouts.dashboard')

@section('content')

    <section class="blog-post-wrap">
        <div class="container">

            <div class="row">
                <div class="col col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">

                    <div class="ui-block responsive-flex">
                        <div class="ui-block-title">
                            <div class="h6 title">Games ({{$groups->total()}})</div>
                            <form class="w-search">
                                <div class="form-group with-button">
                                    <input class="form-control" name="q" type="text" placeholder="Search games..." value="{{ app('request')->input('q') }}">
                                    <button>
                                        <svg class="olymp-magnifying-glass-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-magnifying-glass-icon"></use></svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($groups->count()>0)
                        @if($groups->count())
                            <div class="row">
                                @foreach($groups as $group)
                                    <div class="col col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                        <div class="ui-block">
                                            <article class="hentry blog-post" data-mh="choose-item">
                                                <div class="post-thumb">
                                                    <a href="{!! route('game', ['slug' => $group->slug]) !!}">
                                                        <img src="{{  $group->image ? Storage::disk('public')->url($group->image) : '/img/author-main1.jpg' }}" alt="cover image">
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
                                        {{ $groups->links() }}
                                    </nav>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>

                <div class="col col-xl-3 order-xl-1 col-lg-3 order-lg-1 col-md-12 order-md-2 col-sm-12 responsive-display-none">
                    <div class="ui-block">
                        <div class="your-profile">
                            <div class="ui-block-title ui-block-title-small">
                                <h6 class="title">FILTER</h6>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection