<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use Storage;
use Image;
use File;
use Cache;

class ProfileController extends Controller
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
        $profiles = Auth::user()->profiles;

        if ($request->expectsJson())
        {
            return response()->json($profiles, 200);
        }else{

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $profiles = Auth::user()->profiles()->with(['game'])->get();

        if ($request->expectsJson())
        {
            return response()->json([], 200);
        }else{
            return view('lk.profiles.add', compact(['profiles']));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfileRequest $request)
    {
        $user = Auth::user();
        $userGames = $user->profiles()->pluck('game_id')->toArray();

        $data = $request->all();
        $data['user_id'] = $user->id;
        $data['type'] = Profile::PLAYER;

        if($profile = Profile::create($data))
        {
            return response()->json([
                'data' => $profile,
                'message' => "Your game profiles have been created."
            ], 200);
        }

        return response()->json([
            'error' => 'Select the game.'
        ], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $profile = Auth::user()->profiles()->with(['game'])->findOrFail($id);

        if ($request->expectsJson())
        {
            return response()->json($profile, 200);
        }else{
            return view('lk.profiles.edit', compact(['profile']));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, $id)
    {
        $profile = Auth::user()->profiles()->findOrFail($id);
        $profile->update($request->all());

        return response()->json([
            'data' => $profile,
            'message' => "Your ".$profile->game->title." profile has been updated!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profile = Auth::user()->profiles()->findOrFail($id);
        $profile->delete();

        return response()->json([
            'message' => "Your profile has been deleted!"
        ]);
    }
}
