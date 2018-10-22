@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col col-xl-12 order-xl-2 col-lg-12 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
            <div class="ui-block">
                <div class="ui-block-title">
                    <h6 class="title">Messages</h6>
                    <a href="#" class="more"><svg class="olymp-three-dots-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg></a>
                </div>

                <chat :user="{{json_encode(Auth::user()->toArray())}}"></chat>

                {{--<div class="row">
                    <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <form class="w-search" style="width: 100%; padding: 6px 25px; border-bottom: 1px solid #e6ecf5;">
                            <div class="form-group with-button">
                                <input class="form-control" name="q" type="text" placeholder="Search..." value="{{ app('request')->input('q') }}">
                                <button style="width: 45px">
                                    <svg class="olymp-magnifying-glass-icon"><use xlink:href="/svg-icons/sprites/icons.svg#olymp-magnifying-glass-icon"></use></svg>
                                </button>
                            </div>
                        </form>
                        <ul class="notification-list chat-message">
                            @each('im.partials.thread', $threads, 'thread', 'im.partials.no-threads')
                        </ul>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
