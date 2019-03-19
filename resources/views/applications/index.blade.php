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
                                            Team
                                        </th>
                                        <th class="posts text-left">
                                            Profile
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
                                                    <a href="/universities/{{$application->team->university->slug}}">
                                                        {{$application->team->university->title}}
                                                    </a>
                                                </td>
                                                <td class="forum">
                                                    <a href="/settings/profiles/{{$application->profile_id}}/edit">
                                                        {{$application->team->game->title}}
                                                    </a>
                                                </td>
                                                <td class="forum">
                                                    {{$application->message}}
                                                </td>
                                                <td class="freshness">
                                                    {{App\Models\Application::getStatusTitle($application->status)}}
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
