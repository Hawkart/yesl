<?php

namespace App\Services;

use App\Models\SocialUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SocialAccountService
{
    /**
     * @param $providerObj
     * @param $providerName
     * @param Request $request
     * @return array
     */
    public function createOrGetUser($providerObj, $providerName, Request $request)
    {
        $providerUser = $providerObj->stateless()->user();
        //dd($providerUser);

        $account = SocialUser::whereProvider($providerName)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account)
        {
            return $account->user;
        } else {

            $user = [];
            $email = $providerUser->getEmail();
            if(!empty($email))
            {
                $users = User::where('email', $email);
                if($users->count()>0)
                    $user = $users->first();
            }

            if(empty($user))
                $user = User::createBySocialProvider($providerUser);

            $account = new SocialUser([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $providerName
            ]);
            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}
