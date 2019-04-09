<?php

namespace App\Http\Controllers;

use App\Services\SocialAccountService;
use Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Google_Service_People;

class SocialController extends Controller
{
    /**
     * @param $provider
     * @param Request $request
     * @return mixed
     */
    public function login($provider, Request $request)
    {
        if($provider=="google")
        {
            return Socialite::with($provider)
                ->scopes(['openid', 'profile', 'email', Google_Service_People::CONTACTS_READONLY])
                ->redirect();
        }else{
            return Socialite::with($provider)->redirect();
        }
    }

    /**
     * @param SocialAccountService $service
     * @param $provider
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function callback(SocialAccountService $service, $provider, Request $request)
    {
        $driver = Socialite::driver($provider);
        $user = $service->createOrGetUser($driver, $provider, $request);

        if(!$user)
        {
            return redirect('login')->with('status', "Something wrong. User isn't created.");
        }else{
            if(Auth::loginUsingId($user->id)){
                return redirect('/');
            }
        }
    }
}
