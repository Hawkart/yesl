<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    /**
     * Instantiate a new controller instance.
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
        $user = Auth::user();

        return view('friends.index', compact(['user']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function possible(Request $request)
    {
        $user = Auth::user();

        $this->seo()->setTitle('Possible Friends');

        return view('friends.possible', compact(['user']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function find(Request $request)
    {
        $user = Auth::user();

        $this->seo()->setTitle('Friend search');

        return view('friends.find', compact(['user']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function requestsIn(Request $request)
    {
        $user = Auth::user();

        $this->seo()->setTitle('Incoming friend requests');

        return view('friends.requests_in', compact(['user']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function requestsOut(Request $request)
    {
        $user = Auth::user();

        $this->seo()->setTitle('Outgoing friend requests');

        return view('friends.requests_out', compact(['user']));
    }

}
