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

        $games = [];
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
                    'data' => Auth::user()->profiles,
                    'message' => "Your games profiles created."
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
        //
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