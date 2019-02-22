@extends('layouts.dashboard')

@section('content')

    <section class="blog-post-wrap">
        <div class="container">

            <div class="row">
                <div class="col col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="ui-block">
                        <div class="your-profile">
                            <div class="ui-block-title ui-block-title-small">
                                <h5 class="title">FILTER</h5>
                            </div>
                            <div class="ui-block-content">
                                <form class="form-horizontal mt-10" method="GET">
                                    <div class="row">
                                        <div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <!--<label class="control-label">State:</label>-->
                                                <div class="w-select pa-0">
                                                    <fieldset class="form-group">
                                                        {{ Form::select('state', $states, app('request')->input('state'), ['class' => 'selectpicker form-control']) }}
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="w-select pa-0">
                                                    <fieldset class="form-group">
                                                        <major-select val="{{app('request')->input('major_id')}}"></major-select>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <div><label class="control-label bold">Average SAT score:</label></div>
                                                <div class="btn-group bootstrap-select form-control mt-30">
                                                    <range-slider aval="{{json_encode([app('request')->input('sat_from') ? app('request')->input('sat_from'): $sat_min, app('request')->input('sat_to') ? app('request')->input('sat_to'):$sat_max])}}" :min="{{$sat_min}}" :max="{{$sat_max}}" reff="Sat" name="sat"></range-slider>
                                                </div>
                                                <div class="range-bar">
                                                    <span class="min">{{$sat_min}}</span>
                                                    <span class="max pull-right">{{$sat_max}}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <div><label class="control-label bold">Instate/outstate tution:</label></div>
                                                <div class="btn-group bootstrap-select form-control mt-30">
                                                    <range-slider aval="{{json_encode([app('request')->input('tution_from') ? app('request')->input('tution_from'): $tution_min, app('request')->input('tution_to') ? app('request')->input('tution_to'):$tution_max])}}" :min="{{$tution_min}}" :max="{{$tution_max}}" reff="Tution" name="tution"></range-slider>
                                                </div>
                                                <div class="range-bar">
                                                    <span class="min">{{$tution_min}}</span>
                                                    <span class="max pull-right">{{$tution_max}}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="in_state" {{app('request')->input('in_state')=='on' ? 'checked' : ''}}>
                                                    I'm in-state student
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                            <button class="btn btn-primary full-width">Search</button>
                                            <a href="{{route('universities')}}" class="full-width mb-0">Clear</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">

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
                                        <article class="hentry blog-post university-article">
                                            <div class="post-thumb" data-mh="choose-item">
                                                <a href="{!! route('university', ['slug' => $group->slug]) !!}">
                                                    <img src="{{  $group->image ? Storage::disk('public')->url($group->image) : '/img/university-logo-default.jpg'  }}" alt="{{$group->title}}">
                                                </a>

                                                @if($group->groupable->vacancies()->count()>0)
                                                    <a href="/universities/{{$group->slug}}/vacancies" class="bg-violet label-recruting">Recruiting</a>
                                                @endif
                                            </div>

                                            <div class="post-content" data-mh="choose-item-2">
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
                                    {{ $groups->appends(request()->input())->links() }}
                                </nav>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                No results, change the parameters of filter.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
