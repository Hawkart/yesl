<?php

namespace App\Http\Controllers;

use App\Models\University;
use App\Models\GameUniversity;
use App\Models\Vacancy;
use App\Models\Team;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Storage;
use Image;
use File;
use Cache;
use DB;

class UniversityController extends Controller
{
    use SEOToolsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $universities = University::orderBy('title', 'asc')
            ->select(['title', 'id'])
            ->search($request)
            ->paginate(30);

        return response()->json($universities, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function groups(Request $request)
    {
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

        $uids = $groups->pluck('groupable_id')->toArray();
        $recruiting = Team::whereIn('university_id', $uids)
                        ->where('players_needed', true)
                        ->pluck('university_id')
                        ->toArray();

        $recruiting = array_unique($recruiting);

        $this->seo()->setTitle("Universities");

        return view('universities.index', compact('groups', 'states', 'sat_min', 'sat_max', 'tution_min', 'tution_max', 'recruiting'));
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
        $university = University::findOrFail($id);
        return response()->json($university, 200);
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
     * @param Request $request
     */
    public function groupsWithCoach(Request $request)
    {
        $groups = Group::orderBy('title', 'asc')
            ->where('groupable_type', 'App\Models\University')
            ->whereNotNull('coach_email')
            ->search($request)->paginate(24);

        $this->seo()->setTitle("Write message to the coach");

        return view('universities.write_to_coach', compact('groups'));
    }

    /**
     * @param Request $request
     */
    public function groupsApplyToTeam(Request $request)
    {
        $groups = Group::orderBy('title', 'asc')
            ->where('groupable_type', 'App\Models\University')
            ->whereHas('owner', function($q){
                $q->where('role_id', '<>', 1);
            })->search($request)->paginate(24);

        $this->seo()->setTitle("Apply to team");

        return view('universities.apply_to_team', compact('groups'));
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

        if(count($items)>0)
        {
            $vs = [];
            foreach($items as $vacancy)
            {
                if(!isset($vs[$vacancy->game_id]))
                {
                    $vs[$vacancy->game_id] = [
                        'game' => $vacancy->game,
                        'data' => []
                    ];
                }

                $vs[$vacancy->game_id]['data'][] = $vacancy;
            }

            $items = $vs;
            unset($vs);
        }

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
                    'message' => "Teams have been successfully added."
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
            'message' => "Team has been deleted."
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function vacanciesAdd($id, Request $request)
    {
        $user = Auth::user();
        $university = University::findOrFail($id);

        if($university->group->owner_id!=$user->id)
        {
            return response()->json([
                'user' => "Only admin of group can create team for university!"
            ], 422);
        }

        if(Vacancy::where('university_id', $university->id)->where('game_id', $request->get('game_id'))->count()>0)
            return response()->json([
                'game_id' => "Request with this game is already created!"
            ], 422);

        $vacancy = Vacancy::create([
            'university_id' => $university->id,
            'game_id' => $request->get('game_id')
        ]);

        if($vacancy)
        {
            $items = $university->vacancies()->with(['game'])->get();

            return response()->json([
                'data' => $items,
                'message' => "Vacancy has been successfully added."
            ], 200);
        }

        return response()->json([
            'error' => 'Something wrong'
        ], 422);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function teamsAdd($id, Request $request)
    {
        $user = Auth::user();
        $university = University::findOrFail($id);
        $universityGames = $university->teams()->pluck('game_id')->toArray();

        if($university->group->owner_id!=$user->id)
        {
            return response()->json([
                'user' => "Only admin of group can create team for university!"
            ], 422);
        }

        if(Team::where('university_id', $university->id)->where('game_id', $request->get('game_id'))->count()>0)
            return response()->json([
                'game_id' => "Request with this game is already created!"
            ], 422);


        $teams = [];
        if($request->has('games'))
        {
            $games = $request->get('games');
            $vacancies = $request->get('vacancies');

            foreach($games as $game)
            {
                if(!in_array($game, $universityGames))
                {
                    $team = Team::create([
                        'title' => $university->title." ".$game,
                        'university_id' => $university->id,
                        'game_id' => $game,
                        'players_needed' => in_array($game, $vacancies),
                        'status' => Team::STATUS_ACTIVE
                    ]);

                    $teams[] = $team;
                }
            }

            if(count($teams)>0)
            {
                $items = $university->teams()->with(['game'])->get();

                return response()->json([
                    'data' => $items,
                    'message' => "Teams have been successfully added."
                ], 200);
            }
        }

        return response()->json([
            'error' => 'Something wrong'
        ], 422);
    }
}
