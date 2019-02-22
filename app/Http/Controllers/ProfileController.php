<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
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
    public function store(Request $request)
    {
        $user = Auth::user();
        $userGames = $user->profiles()->pluck('game_id')->toArray();
        $profiles = [];

        if($request->has('games'))
        {
            $games = $request->get('games');

            foreach($games as $game)
            {
                if(!in_array($game, $userGames))
                {
                    $profile = Profile::create([
                        'user_id' => $user->id,
                        'game_id' => $game,
                        'nickname' => $user->nickname,
                        'type' => Profile::PLAYER
                    ]);

                    $profiles[] = $profile;
                }
            }

            if(count($profiles)>0)
            {
                return response()->json([
                    'data' => Auth::user()->profiles()->with(['game'])->get(),
                    'message' => "Your game profiles have been created."
                ], 200);
            }
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
    public function update(Request $request, $id)
    {
        $profile = Auth::user()->profiles()->findOrFail($id);

        $validator = [
            'nickname' => 'required|string|max:255',
            'link' => 'url'
        ];

        $request->validate($validator);
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
