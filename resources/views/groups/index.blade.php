@extends('layouts.dashboard')

@section('content')

<section class="blog-post-wrap">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">

                <div class="ui-block responsive-flex">
                    <div class="ui-block-title">
                        <div class="h6 title">My Groups ({{$groups->total()}})</div>
                        <a href="#" class="btn btn-primary btn-sm btn-right float-right">Create group +</a>
                    </div>
                    <div class="ui-block-title">
                        <form class="w-search w-100">
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
                    <div class="ui-block">
                        <div class="row">
                            @foreach($groups as $group)
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="birthday-item inline-items" style="border-bottom: 1px solid rgba(0, 0, 0, 0.1)">
                                        <div class="author-thumb w-50px">
                                            <a href="{!! route('group', ['slug' => $group->slug]) !!}">
                                                <img src="{{  $group->image ? Storage::disk('public')->url($group->image) : '/img/author-main1.jpg' }}" alt="cover image">
                                            </a>
                                        </div>
                                        <div class="birthday-author-name ml-2">
                                            <a href="{!! route('group', ['slug' => $group->slug]) !!}" class="h5 author-name" title="{{$group->title}}">
                                                {{ str_limit($group->title, 50, '...') }}
                                            </a><br>
                                            <i class="fas fa-users"></i> {{$group->users()->count()}}
                                        </div>
                                        <a href="#" data-toggle="modal" data-target="#warning-resume-profile" class="btn btn-success btn-md btn-apply">Apply to the Team</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
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
