<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;
use App\Models\GroupUser;
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
        $groups = Group::orderBy('id', 'desc')->search($request)->paginate(12);

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
            ->with(['user', 'likes', 'comments', 'likes.user', 'comments.user', 'comments.likes', 'media'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return response()->json($posts);
    }

    /**
     * Get posts of group
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkUserIsMember($id, Request $request)
    {
        $gu = GroupUser::where("group_id", $id)->where('user_id', Auth::id());
        if($gu->count()>0)
        {
            return response()->json($gu->first());
        }else{
            return response()->json([]);
        }
    }

    /**
     * Get posts of group
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function join($id, Request $request)
    {
        $user = Auth::user();
        $group = Group::findOrFail($id);
        /*$gu = GroupUser::withTrashed()->where("group_id", $id)->where('user_id', Auth::id())->first();

        if($gu)
        {
            if ($gu->trashed()) {
                $gu->restore();
            }else{
                $gu->delete();
            }
        }else{
            $user->groups()->attach($group->id);
        }*/

        $gu = GroupUser::where("group_id", $id)->where('user_id', Auth::id())->first();

        $m = 'Something wrong';
        if($gu)
        {
            $user->groups()->detach($group->id);
            $m = "You have successfully unsubscribed!";
        }else{
            $user->groups()->attach($group->id);
            $m = "You have successfully subscribed!";
        }

        return response()->json(['message' => $m], 200);
    }
}