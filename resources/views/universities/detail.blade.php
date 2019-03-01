@extends('layouts.dashboard')

@section('content')
    @include('universities._partials.top')

    <div class="container">
        <div class="row">
            <div class="col-xl-6 order-xl-2 col-lg-12 order-lg-3 order-md-3 order-sm-3 order-3 col-sm-12 col-12">

                {{--@if(strpos($group->owner->email, '@campusteam.tv')===false)
                    @if($can_post)
                        <div class="ui-block">
                            <post-form :user="{{json_encode(Auth::user()->toArray())}}" :group="{{json_encode($group->toArray())}}"></post-form>
                        </div>
                    @endif

                    <post-list :user="{{json_encode(Auth::user()->toArray())}}" :group="{{json_encode($group->toArray())}}" type="group"></post-list>
                @else--}}
                    @php
                        $tw = $group->groupable->twitter_str;
                        if(!empty($tw))
                        {
                            $tw = explode(',', $tw);

                            if(!$group->owner->isAdmin() && isset($tw[1]))
                            {
                                $tw = $tw[1];
                            }else{
                                $tw = $tw[0];
                            }
                            
                            if(empty($tw))
                                $tw = $tw[0];
                        }
                    @endphp
                    @if(!empty($tw))
                        <a class="twitter-timeline" href="https://twitter.com/{{$tw}}">Tweets by {{$tw}}</a>
                        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                    @else
                        <div class="text-center mt-1">No results(:</div>
                    @endif
                {{--@endif--}}
            </div>

            @include('universities._partials.left')
            @include('universities._partials.right')
        </div>
    </div>
@endsection
