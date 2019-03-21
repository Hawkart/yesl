@extends('layouts.dashboard')

@section('content')
    <section class="blog-post-wrap">
        <div class="container">
            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-2"></div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">

                    <div class="ui-block mt-2">
                        <div class="ui-block-content">

                            <h2 class="text-center mt-2 mb-4">Resume</h2>
                            <div class="row">

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 lk-avatar">
                                    <div class="form-group">
                                        <label class="control-label">Name:</label>
                                        {{$application->user->first_name}} {{$application->user->second_name}} {{$application->user->last_name}}
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Summary:</label>
                                        {{$application->user->description}}
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Discord username:</label>
                                        {{$application->user->discord_nickname}}
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Phone Number:</label>
                                        {{$application->user->phone}}
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Applying as an international student:</label>
                                        {{$application->user->is_foreign==1 ? 'Yes' : 'No'}}
                                    </div>
                                </div>

                                @if($application->user->is_foreign==1)
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">TOEFL paper:</label>
                                            {{$application->user->toefl_paper}}
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">TOEFL computer based:</label>
                                            {{$application->user->toefl_computer}}
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">TOEFL internet:</label>
                                            {{$application->user->toefl_internet}}
                                        </div>
                                    </div>
                                @endif

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">User applying as:</label>
                                        {{$application->user->apply_as==0 ? "First-Year" : "Transfer"}}
                                    </div>
                                </div>

                                @if(intval($application->user->apply_as)==0)
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">ACT scores:</label>
                                            {{$application->user->act_scored}}
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">SAT scores:</label>
                                            {{$application->user->sat_scored}}
                                        </div>
                                    </div>
                                @else
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">Transferable college credit hours:</label>
                                            {{$application->user->transfer_hours}}
                                        </div>
                                    </div>
                                @endif

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">GPA:</label>
                                        {{$application->user->gpa}}
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Mailing Address:</label>
                                        {{$application->user->street}}, {{$application->user->city}},
                                        @if(!empty($application->user->state))
                                            {{$application->user->state}},
                                        @endif
                                        {{$application->user->postal_code}},
                                        {{$application->user->country}}
                                    </div>
                                </div>
                            </div>

                            <h2 class="text-center mt-2 mb-4">Gamer Profile</h2>
                            <div class="row">

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 lk-avatar">
                                    <div class="form-group">
                                        <label class="control-label">Game:</label>
                                        {{$application->profile->game->title}}
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Name in {{$application->profile->game->title}}:</label>
                                        {{$application->profile->nickname}}
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Current rank:</label>
                                        {{$application->profile->rank}}
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Peak rank for this or past season:</label>
                                        {{$application->profile->peak_rank}}
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Link to ranked profile:</label>
                                        {{$application->profile->link}}
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Additional link to any other ranked gamer profile:</label>
                                        {{$application->profile->additional_link}}
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Link to streaming (Twitch/Mixer/ etc.) Account:</label>
                                        {{$application->profile->streaming_link}}
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Has player been banned by {{$application->profile->game_dev}}?</label>
                                        {{$application->profile->have_banned==1 ? 'Yes' : 'No'}}
                                    </div>
                                </div>

                                @if(count($application->profile->progress)>0)
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <h6 class="mt-2">List of the tournaments player has been competed in:</h6>

                                    @foreach($application->profile->progress as $tournament)
                                        <hr/>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Date:</label>
                                                    {{$tournament['year']}}-{{$tournament['month']}}-00
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Tournament title:</label>
                                                    {{$tournament['title']}}
                                                </div>
                                            </div>

                                            @if($tournament['is_lan']==1)
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Place of tournament:</label>
                                                    {{$tournament['location']}}
                                                </div>
                                            </div>
                                            @endif

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Team:</label>
                                                    {{$tournament['team']}}
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Organizer Name:</label>
                                                    {{$tournament['org_name']}}
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Link to organizer website:</label>
                                                    {{$tournament['org_link_site']}}
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Place in tournament:</label>
                                                    {{$tournament['place']}}
                                                </div>
                                            </div>


                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Link to the webpage with confirmation of the place in tournament:</label>
                                                    {{$tournament['place_confirm_link']}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>


                            @if($application->status==0)
                                <div class="row inline-items">

                                    <form action="/application/{{$application->id}}" method="POST">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="status" value="1">
                                        <button class="btn btn-success btn-xs">Invite for interview</button>
                                    </form>

                                    <form action="/application/{{$application->id}}" method="POST">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="status" value="2">
                                        <button class="btn btn-success btn-xs">Reject</button>
                                    </form>

                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
