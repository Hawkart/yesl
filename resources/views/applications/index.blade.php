@extends('layouts.dashboard')

@section('content')
    <section class="blog-post-wrap">
        <div class="container">

            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="ui-block">
                        <div class="your-profile">
                            <div class="ui-block-title ui-block-title-small">
                                <h5 class="title">FILTER</h5>
                            </div>
                            <div class="ui-block-content">
                                <form class="form-horizontal mt-10" method="GET">
                                    <div class="row">
                                        <div class="col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="w-select pa-0">
                                                    <fieldset class="form-group">
                                                        {{ Form::select('game_id', $games, app('request')->input('game_id'), ['class' => 'selectpicker form-control']) }}
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                            <button class="btn btn-primary full-width">Search</button>
                                            <a href="{{route('applications')}}" class="full-width mb-0">Clear</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">

                    <div class="ui-block responsive-flex">
                        <div class="ui-block-title">
                            <h6 class="title">Applications</h6>
                        </div>
                        <div class="ui-block-content">

                            @if(count($applications)>0)
                                <table class="forums-table">
                                    <thead>
                                    <tr>
                                        <th class="forum">
                                            Date
                                        </th>
                                        <th class="topics text-left">
                                            Application
                                        </th>
                                        <th class="topics text-left">
                                            Team
                                        </th>
                                        <th class="forum">
                                            Message
                                        </th>
                                        <th class="freshness">
                                            Status
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($applications as $application)
                                            <tr>
                                                <td class="forum">
                                                    {{$application->created_at->format('Y-m-d')}}
                                                </td>
                                                <td class="forum">
                                                    <a href="/applications/{{$application->id}}" target="_blank" class="btn btn-primary btn-xs">
                                                        Resume + Gamer Profile
                                                    </a>
                                                </td>
                                                <td class="forum">
                                                    <a href="/universities/{{$application->team->university->slug}}">
                                                        {{$application->team->game->title}}
                                                    </a>
                                                </td>
                                                <td class="forum">
                                                    <a href="#" onclick="document.getElementById('application-message').innerHTML='{{$application->message}}'" data-toggle="modal" data-target="#application-message-modal" class="btn btn-success btn-xs">Show message</a>
                                                </td>
                                                <td class="freshness">
                                                    {{App\Models\Application::getStatusTitle($application->status)}}

                                                    @if($application->status==1)
                                                        <chat-dialog-button :participant='{{json_encode($application->user->toArray()) }}' :group_id = "0" :classes="'pa-0 full-width mb-0'">
                                                            <button type="submit" class="btn bg-violet btn-xs full-width mt-0">Write Message to the Athlete</button>
                                                        </chat-dialog-button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                        <nav aria-label="Page navigation">
                                            {{ $applications->appends(request()->input())->links() }}
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
            </div>
        </div>
    </section>
@endsection
