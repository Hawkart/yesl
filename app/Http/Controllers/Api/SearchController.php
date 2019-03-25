<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Group;
use Cache;
use Mail;

class SearchController extends Controller
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
    public function search(Request $request)
    {
        if($request->has('q'))
        {
            $users = User::orderBy('name', 'asc')
                ->where('id', '<>', Auth::id())
                ->search($request)
                ->verified()
                ->limit(5)->get()->toArray();

            $groups = Group::orderBy('title', 'asc')
                ->where('groupable_type', 'App\Models\University')
                ->search($request)
                ->limit(5)->get()->toArray();

            return response()->json(array_merge($users, $groups), 200);
        }
    }
}
