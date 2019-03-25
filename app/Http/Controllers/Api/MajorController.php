<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\MajorResource;
use Illuminate\Http\Request;
use App\Models\Major;
use App\Models\MajorUniversity;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;
use Storage;
use Image;
use File;
use Cache;
use DB;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $majors = Major::orderBy('title', 'asc')
            ->whereHas('universities', function($q){
                $q->where('nace', 1);
            });

        $items = QueryBuilder::for($majors)
            ->allowedIncludes(['universities'])
            ->allowedFilters([]);

        if($request->has('page'))
        {
            $items = $items->paginate($request->has('limit') ? $request->get('limit') : 12);
        }else{
            $items = $items->get();
        }

        return MajorResource::collection($items);
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
     * @param Major $major
     * @return MajorResource
     */
    public function show(Major $major)
    {
        return new MajorResource($major);
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
