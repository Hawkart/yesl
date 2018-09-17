<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Requests\UserPasswordUpdateRequest;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

class UserController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the personal form.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $this->seo()->setTitle('Personal settings');
        $user = Auth::user();
        return view('lk.personal', compact('user'));
    }

    /**
     * Show the password form.
     *
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        $this->seo()->setTitle('Change password');

        $user = Auth::user();
        return view('lk.password', compact('user'));
    }


    /**
     * Update user personal data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required',
            'date_birth' => 'required|date_format:Y-m-d|before:today'
        ];

        $request->validate($validator);
        $user->update($request->all());

        return back()->with('status', "Personal info updated!");
    }

    /**
     * Update user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function updatePassword(UserPasswordUpdateRequest $request)
    {
        $user = Auth::user();

        if($result = $user->update([
            'password' => \Hash::make($request->get('password'))
        ]))
        {
            return response()->json([
                'data' => $user,
                'message' => "Password is updated."
            ]);
        }

        return response()->json([
            'error' => 'Something wrong'
        ], 422);
    }

    /**
     * Update user's passsword.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function profiles()
    {
        $user = Auth::user();
        $games = Game::all();

        return view('lk.profiles', compact(['user', 'games']));
    }
}
