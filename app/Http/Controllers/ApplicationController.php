<?php

namespace App\Http\Controllers;

use App\Mail\EmailApplicationToCoach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Http\Requests\ApplicationRequest;
use Storage;
use Image;
use File;
use Cache;
use Mail;

class ApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationRequest $request)
    {
        $data = $request->all();

        if($result = Application::create($data))
        {
            $result->load(['team.university', 'team.university.owner', 'team.game', 'user']);
            $university = $result->team->university;
            $group = $university->group;

            if(isset($group->owner) && strpos($group->owner->email, 'campusteam.tv')===false)
            {
                $data = [
                    'game' => $result->team_game,
                    'user' => $result->user,
                    'coach' => $group->owner,
                    'application' => $result
                ];
                Mail::to($group->owner->email)->send(new EmailApplicationToCoach($data));
                Mail::to(env('ADMIN_EMAIL'))->send(new EmailApplicationToCoach($data));
            }

            return response()->json([
                'data' => $result,
                'message' => "Application has been successfully created."
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $application = Application::findOrFail($id);

        //check the owner
        if($application->team->university->group->owner_id==Auth::user()->id)
        {
            $application->load(['team', 'profile.game', 'profile', 'user']);
            return view('applications.detail', compact(['application']));
        }else{
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);

        //check the owner
        if($application->team->university->group->owner_id==Auth::user()->id)
        {
            $application->update($request->only('status'));

            if($request->get('status')==1)
            {
                $message = "Application status has been updated. Write message to athlete about datetime of interview.";
            }else{
                $message = "Application status has been updated.";
            }

            return redirect('applications')->with('status', $message);
        }else{
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
