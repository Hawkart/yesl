<?php

namespace App\Http\Controllers;

use App\Models\University;
use App\Models\GameUniversity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;
use Image;
use File;
use Cache;
use DB;

class UniversityController extends Controller
{
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
    public function store(Request $request)
    {
        //
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

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function vacancies($id, Request $request)
    {
        $university = University::findOrFail($id);
        $items = $university->vacancies;
        return response()->json($items, 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function games($id, Request $request)
    {
        $university = University::findOrFail($id);
        $items = $university->games;
        return response()->json($items, 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function gamesAdd($id, Request $request)
    {
        $user = Auth::user();
        $university = University::findOrFail($id);
        $universityGames = $university->games()->pluck('game_id')->toArray();

        if($university->group->owner_id!=$user->id)
        {
            return response()->json([
                'user' => "Only admin of group can create team for university!"
            ], 422);
        }

        if($request->has('games'))
        {
            $games = $request->get('games');

            foreach($games as $game)
            {
                if(!in_array($game, $universityGames))
                {
                    $profile = GameUniversity::create([
                        'university_id' => $university->id,
                        'game_id' => $game
                    ]);

                    $profiles[] = $profile;
                }
            }

            if(count($profiles)>0)
            {
                return response()->json([
                    'data' => $university->games,
                    'message' => "University's teams haave been successfully created!"
                ], 200);
            }
        }

        return response()->json([
            'error' => 'Select the game.'
        ], 422);
    }

    /**
     * @param $id
     * @param $gid
     * @return \Illuminate\Http\JsonResponse
     */
    public function gamesDelete($id, $gid)
    {
        $user = Auth::user();
        $university = University::findOrFail($id);

        if($university->group->owner_id!=$user->id)
        {
            return response()->json([
                'user' => "Only admin of group can delete team for university!"
            ], 422);
        }

        $gu = GameUniversity::where('university_id', $university->id)->where('game_id', $gid)->first();
        $gu->delete();

        return response()->json([
            'message' => "Team has been deleted!"
        ]);
    }
}
