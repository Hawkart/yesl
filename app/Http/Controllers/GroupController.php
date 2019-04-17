<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\Game;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Support\Facades\Mail;
use Storage;
use Image;
use File;
use Cache;
use App\Acme\Helpers\TwitterHelper;
use App\Http\Requests\GroupRequest;
use App\Mail\EmailGroupModerate;

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
        $this->middleware('auth', ['except' => ['universities']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $groups = Group::orderBy('title', 'desc')->active()
                        ->whereNull('groupable_type')
                        ->search($request)->paginate(12);

        $this->seo()->setTitle("Groups");

        return view('groups.search', compact('groups'));
    }

    /**
     * @param $slug
     * @param Request $request
     */
    public function universityTeams($slug, Request $request)
    {
        $group = Group::where('slug', $slug)
            ->firstOrFail();

        $vacancies = [];
        if($group->groupable instanceof \App\Models\University)
            $teams = $group->groupable->teams()->with(['game'])->get();

        $twitts = TwitterHelper::getByStr($group->groupable->twitter_str);
        $this->seo()->setTitle($group->title." teams");

        return view('universities.teams.index', compact('group', 'teams', 'twitts'));
    }

    /**
     * @param $slug
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function universityGames($slug, Request $request)
    {
        $group = Group::where('slug', $slug)
            ->firstOrFail();

        $games = [];
        if($group->groupable instanceof \App\Models\University)
            $games = $group->groupable->games;

        $twitts = TwitterHelper::getByStr($group->groupable->twitter_str);
        $this->seo()->setTitle($group->title." teams");

        return view('universities.games.index', compact('group', 'games', 'twitts'));
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
     * @param GroupRequest $request
     */
    public function store(GroupRequest $request)
    {
        $user = Auth::user();

        $group = Group::create([
            'owner_id' => $user->id,
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'status' => Group::STATUS_PENDING
        ]);

        $user->groups()->attach($group->id);

        Mail::to(env("ADMIN_EMAIL"))->send(new EmailGroupModerate($group));

        return response()->json([
            'data' => $group,
            'message' => "After moderation, your group will be activated."
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug, Request $request)
    {
        $user = Auth::user();

        $group = Group::where('slug', $slug)
            ->where(function($q) use ($user) {
                $q->active()
                    ->orWhere('owner_id', $user->id);
            })
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

        $groups = $user->groups()->pluck('group_id')->toArray();
        $can_post = in_array($group->id, $groups) && $group->isActivated();

        $this->seo()->setTitle($group->title);

        return view ('groups.detail', compact(['group', 'similar_groups', 'can_post']));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLogo($id, Request $request)
    {
        $group = Group::findOrFail($id);
        $params = $request->all();

        if(Auth::user()->id!=$group->owner_id)
        {
            return response()->json([
                'error' => 'Only admin of group can update logo!'
            ], 422);
        }

        if($group->image)
        {
            $path = public_path() . '/storage/' . $group->image;

            if(file_exists($path) && !in_array($group->image, ['img/university-logo-default.jpg']))
                unlink($path);
        }

        $path = Storage::disk('public')->putFile(
            'groups', $request->file('files')
        );

        /**
         * Crop & resize using client crop data
         */

        if($request->has('toCropImgH'))
        {
            $crop = [
                'h' => (int)$params["toCropImgH"],
                'w' => (int)$params["toCropImgW"],
                'x' => (int)$params["toCropImgX"],
                'y' => (int)$params["toCropImgY"]
            ];
        }else{
            $crop = [
                'h' => (int)$params["h"],
                'w' => (int)$params["w"],
                'x' => (int)$params["x"],
                'y' => (int)$params["y"]
            ];
        }

        $img = Image::make('storage/'.$path);
        $img->crop($crop['h'], $crop['w'], $crop['x'], $crop['y']);
        $img->resize(120, 120);
        $img->save('storage/'.$path);
        $img->destroy();

        $group->image = $path;
        $group->update();

        return response()->json([
            'data' => $group,
            'message' => "Logo has been successfully updated."
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCover($id, Request $request)
    {
        $group = Group::findOrFail($id);

        if(Auth::user()->id!=$group->owner_id)
        {
            return response()->json([
                'error' => 'Only admin of group can update cover!'
            ], 422);
        }

        if(!empty($group->cover))
        {
            $path = public_path() . '/storage/' . $group->cover;
            if(file_exists($path) && !in_array($group->cover, ['img/university-overlay-default.jpg']))
                unlink($path);
        }

        $path = Storage::disk('public')->putFile(
            'groups', $request->file('files')
        );
        $group->cover = $path;
        $group->update();

        return response()->json([
            'data' => $group,
            'message' => "Cover has been successfully updated."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function university($slug, Request $request)
    {
        $group = Group::where('slug', $slug)
            ->firstOrFail();

        $similar_groups = [];
        $user = Auth::user();
        $groups = $user->groups()->pluck('group_id')->toArray();
        $can_post = in_array($group->id, $groups) && $group->owner_id==$user->id;

        $twitts = TwitterHelper::getByStr($group->groupable->twitter_str);

        $this->seo()->setTitle($group->title);

        return view ('universities.detail', compact(['group', 'similar_groups', 'can_post', 'twitts']));
    }


    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function game($slug, Request $request)
    {
        $group = Group::where('slug', $slug)
            ->firstOrFail();

        $similar_groups = [];
        $genre_id = $group->groupable->genre_id;
        $games = Game::where('genre_id', $genre_id)->where('id', "<>", $group->groupable->id)->limit(5)->get();
        foreach($games as $game)
        {
            $similar_groups[] = $game->group;
        }

        $user = Auth::user();
        $groups = $user->groups()->pluck('group_id')->toArray();
        $can_post = in_array($group->id, $groups) && $group->owner_id==$user->id;

        $this->seo()->setTitle($group->title);

        return view ('games.detail', compact(['group', 'similar_groups', 'can_post']));
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
    public function update(GroupRequest $request, $id)
    {
        $group = Group::findOrFail($id);

        if(Auth::user()->id!=$group->owner_id)
        {
            return response()->json([
                'error' => 'Only admin of group can update info.!'
            ], 422);
        }

        $group->update([
            'description' => $request->get('description')
        ]);

        return response()->json([
            'data' => $group,
            'message' => "Group's description has been updated."
        ], 200);
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
