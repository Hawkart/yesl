<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vacancy;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Storage;
use Image;
use File;
use Cache;

class VacancyController extends Controller
{
    use SEOToolsTrait;

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
    public function store(Request $request)
    {
        $user = Auth::user();

        if($user->university_id>0)
        {
            $university = $user->university;
            $group = $university->group;

            if($group)
            {
                if($user->id!=$group->owner_id)
                {
                    return response()->json([
                        'error' => "You aren't administrator of group."
                    ], 422);
                }
            }else{
                return response()->json([
                    'error' => "You don't have university's group connection."
                ], 422);
            }

        }else{
            return response()->json([
                'error' => "You don't have university connection."
            ], 422);
        }

        //Todo: validator of request

        $vacancy = Vacancy::create([
            'university_id' => $university->id,
            'game_id' => $request->get('game_id'),
            'game_role' => $request->get('game_role'),
            'ranking' => $request->get('ranking')
        ]);

        if($vacancy)
        {
            return response()->json([
                'data' => $vacancy,
                'message' => "Vacancy has been successfully created."
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug, Request $request)
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
