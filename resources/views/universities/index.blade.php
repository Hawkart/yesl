@extends('layouts.dashboard')

@section('content')

    <section class="blog-post-wrap">
        <div class="container">

            <div class="row">
                <div class="col col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">

                    <div class="ui-block responsive-flex">
                        <div class="ui-block-title">
                            <div class="h6 title">Universities ({{$groups->total()}})</div>
                            <form class="w-search">
                                <div class="form-group with-button">
                                    <input class="form-control" name="q" type="text" placeholder="Search universities..." value="{{ app('request')->input('q') }}">
                                    <button>
                                        <svg class="olymp-magnifying-glass-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-magnifying-glass-icon"></use></svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($groups->count()>0)
                        <div class="row">
                            @foreach($groups as $group)
                                <div class="col col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="ui-block">
                                        <article class="hentry blog-post university-article" data-mh="choose-item-2">
                                            <div class="post-thumb" data-mh="choose-item">
                                                <a href="{!! route('university', ['slug' => $group->slug]) !!}">
                                                    <img src="{{  $group->image ? Storage::disk('public')->url($group->image) : '/img/university-logo-default.jpg'  }}" alt="{{$group->title}}">
                                                </a>
                                            </div>

                                            <div class="post-content">
                                                <a href="{!! route('university', ['slug' => $group->slug]) !!}" class="h5 post-title" title="{{$group->title}}">
                                                    {{ str_limit($group->title, 50, '...') }}
                                                </a>

                                                <div class="comments-shared">
                                                    <i class="fas fa-users"></i>  {{$group->groupable->enrollment_all}}
                                                </div>
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
                </div>

                <div class="col col-xl-3 order-xl-1 col-lg-3 order-lg-1 col-md-12 order-md-2 col-sm-12 responsive-display-none">
                    <div class="ui-block">
                        <div class="your-profile">
                            <div class="ui-block-title ui-block-title-small">
                                <h6 class="title">FILTER</h6>
                            </div>
                            <div class="ui-block-content">
                                <form class="form-horizontal mt-10" method="GET">
                                    <div class="row">
                                        <div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label">State</label>
                                                {{ Form::select('state', $states, app('request')->input('state'), ['class' => 'selectpicker form-control']) }}
                                            </div>
                                        </div>

                                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                            <button class="btn btn-primary full-width mb-0">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection