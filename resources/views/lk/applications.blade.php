@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title">Applications</h6>
                    </div>
                    <div class="ui-block-content">
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
                                @if(count($applications)>0)
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
                                                <a href="#" onclick="document.getElementById('application-message').innerHTML='{{$application->message}}'" data-toggle="modal" data-target="#application-message-modal" class="btn btn-success btn-xs">Show message</a>
                                            </td>
                                            <td class="freshness">
                                                {{App\Models\Application::getStatusTitle($application->status)}}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>

            @include('lk._menu')
        </div>
    </div>
@endsection
