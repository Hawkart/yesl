<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\GroupResource;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\Game;
use Storage;
use Image;
use File;
use Cache;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;

class GroupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['universities']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = QueryBuilder::for(Group::class)
            ->defaultSort('-title')
            ->allowedSorts('title')
            ->allowedIncludes(['owner', 'posts', 'groupable'])
            ->allowedFilters([Filter::scope('type')])
            ->jsonPaginate();

        return GroupResource::collection($groups);
    }

    /**
     * Display a listing of the universities.
     *
     * @return \Illuminate\Http\Response
     */
    public function universities(Request $request)
    {
        if ($request->expectsJson() && $request->ajax())
        {
            $universities = University::orderBy('title', 'asc')
                ->select(['title', 'id'])
                ->search($request)
                ->paginate(30);

            return response()->json($universities, 200);
        }else {

            $groups = Group::orderBy('title', 'asc')
                ->where('groupable_type', 'App\Models\University')
                ->search($request)->paginate(12);

            $states = Cache::remember('state_list', 3600, function () {
                $st = University::$states;
                $states_id = University::where('nace', 1)->pluck('state')->toArray();
                $states_id = array_unique($states_id);
                $states = ['0' => 'Select state'];
                foreach ($st as $key => $value) {
                    if (in_array($key, $states_id)) {
                        $states[$key] = $value;
                    }
                }

                return $states;
            });

            $sat_min = Cache::remember('sat_min', 3600, function () {
                return University::where('nace', 1)->min('sat_scores_average_overall');
            });

            $sat_max = Cache::remember('sat_max', 3600, function () {
                return University::where('nace', 1)->max('sat_scores_average_overall');
            });

            $tution_min = Cache::remember('tution_min', 3600, function () {
                return University::where('nace', 1)->min('cost_tuition_in_state');
            });

            $tution_max = Cache::remember('tution_max', 3600, function () {
                return University::where('nace', 1)->max('cost_tuition_in_state');
            });

            $this->seo()->setTitle("Universities");

            return view('universities.index', compact('groups', 'states', 'sat_min', 'sat_max', 'tution_min', 'tution_max'));
        }
    }

    /**
     * Display a listing of the games.
     *
     * @return \Illuminate\Http\Response
     */
    public function games(Request $request)
    {
        $groups = Group::orderBy('id', 'desc')
            ->where('groupable_type', 'App\Models\Game')
            ->search($request)->paginate(12);

        $this->seo()->setTitle("Games");

        return view('universities.index', compact('groups'));
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

        $user = Auth::user();
        $groups = $user->groups()->pluck('group_id')->toArray();
        $can_post = in_array($group->id, $groups);

        $this->seo()->setTitle($group->title);

        return view ('groups.detail', compact(['group', 'similar_groups', 'can_post']));
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
            ->with(['user', 'likes', 'comments', 'likes.user', 'comments.user', 'comments.reply.user', 'comments.likes', 'media', 'group',
                'parent', 'parent.user', 'parent.group', 'parent.media'])
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
