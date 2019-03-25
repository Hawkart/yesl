<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\University;
use App\Http\Resources\UniversityResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;
use Cache;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = QueryBuilder::for(University::class)
            ->allowedIncludes(['group'])
            ->allowedFilters(['nace', Filter::scope('like_url')]);

        if($request->has('page'))
        {
            $items = $items->paginate($request->has('limit') ? $request->get('limit') : 12);
        }else{
            $items = $items->get();
        }

        return UniversityResource::collection($items);
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
     * @param University $university
     * @return UniversityResource
     */
    public function show(University $university)
    {
        $university->load(['group']);
        return new UniversityResource($university);
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
     * Filter list
     */
    public function filter()
    {
        //slider, string, radio, checkbox, select

        $sliders = //Cache::remember('sat_max', 3600, function () {
            University::nace()->selectRaw("MIN(sat_scores_average_overall) AS min_sat, MAX(sat_scores_average_overall) AS max_sat,
                MIN(cost_tuition_in_state) AS min_tuition, MAX(cost_tuition_in_state) AS max_tuition")->first();
        //});

        $filters = [
            [
                'title' => 'Average SAT score', //Todo: make from lang file
                'name' => 'sat_score',
                'type' => 'slider',
                'multi' => false,
                'values' => [$sliders['min_sat'], $sliders['max_sat']]
            ],
            [
                'title' => 'Instate/outstate tution',   //Todo: make from lang file
                'name' => 'cost_tuition',
                'type' => 'slider',
                'multi' => false,
                'values' => [$sliders['min_tuition'], $sliders['max_tuition']]
            ],
        ];

        return response()->json([
            'data' => $filters
        ]);
    }
}
