<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Game;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Storage;
use Image;
use File;
use Cache;

class GroupController extends Controller
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
        $groups = Group::orderBy('id', 'desc')->paginate(12);

        $this->seo()->setTitle("Groups");

        return view('groups.search', compact('groups'));
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
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug, Request $request)
    {
        $group = Group::where('slug', $slug)
            ->firstOrFail();

        $similar_groups = [];
        if($group->groupable instanceof \App\Models\Game)
        {
            $genre_id = $group->groupable->genre_id;
            $games = Game::where('genre_id', $genre_id)->where('id', "<>", $group->groupable->id)->limit(5)->get();
            foreach($games as $game)
            {
                $similar_groups[] = $game->group;
            }
        }

        $this->seo()->setTitle($group->title);

        return view ('groups.detail', compact(['group', 'similar_groups']));
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
     * Get posts of group
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function posts($id, Request $request)
    {
        $group = Group::findOrFail($id);
        $posts = $group->posts()
            ->with(['user', 'likes', 'comments', 'likes.user', 'comments.user', 'comments.likes'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return response()->json($posts);
    }
}