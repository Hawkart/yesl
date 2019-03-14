@extends('layouts.dashboard')

@section('content')
    <section class="blog-post-wrap">
        <div class="container">

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="ui-block responsive-flex">
                        <div class="ui-block-title">
                            <div class="h6 title">Communications with Coaches ({{$groups->total()}})</div>
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

                        @php
                            $countProfiles = Auth::user()->profiles()->count();
                        @endphp

                        <div class="row">
                            @foreach($groups as $group)
                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 py-1">

                                    <div class="ui-block">
                                        <div class="birthday-item inline-items" data-mh="choose-item">
                                            <div class="w-50px">
                                                <a href="{!! route('university', ['slug' => $group->slug]) !!}">
                                                    <img src="{{  $group->image ? Storage::disk('public')->url($group->image) : '/img/university-logo-default.jpg'  }}" alt="{{$group->title}}" class="w-100">
                                                </a>
                                            </div>
                                            <div class="birthday-author-name ml-2">
                                                <a href="{!! route('university', ['slug' => $group->slug]) !!}" class="h5 author-name" title="{{$group->title}}">
                                                    {{ str_limit($group->title, 25, '...') }}
                                                </a>
                                            </div>

                                            @if(!$group->owner->isAdmin() || !empty($group->coach_email))
                                                @if($countProfiles>0)
                                                    <chat-dialog-button :participant='{{json_encode($group->owner->toArray()) }}' :group_id = "{{$group->id}}" :classes="'pa-0 mb-0'">
                                                        <button type="submit" class="btn bg-violet btn-md mt-0">Write Message to the Coach</button>
                                                    </chat-dialog-button>
                                                @else
                                                    <a href="#" data-toggle="modal" data-target="#warning-profile" class="btn bg-violet btn-md mt-1">Write Message to the Coach</a>
                                                @endif
                                            @endif
                                        </div>
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
