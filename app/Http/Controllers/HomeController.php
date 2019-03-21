<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * @param Request $request
     */
    public function demoAuth(Request $request)
    {
        $user = User::where('email', 'demo@campusteam.tv')->first();

        if (empty($user)) {
            abort(404);
        }

        if(Auth::loginUsingId($user->id)){
            return redirect('/');
        }
    }
}
