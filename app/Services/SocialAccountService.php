<?php

namespace App\Services;

use App\Models\SocialUser;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Acme\Helpers\TwitchHelper;
use Google_Client;
use Google_Service_People;

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
        $providerUser = $providerObj->user();
        $account = SocialUser::whereProvider($providerName)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account)
        {
            return $account->user;
        }
        else
        {
            $providerUser->contacts = [];
            if($providerName=="google")
            {
                // Установим токен в  Google API PHP Client
                $google_client_token = [
                    'access_token' => $providerUser->token
                ];

                $client = new Google_Client();
                $client->setApplicationName(env("GOOGLE_APP_NAME"));
                $client->setDeveloperKey(env('GOOGLE_SERVER_KEY'));
                $client->setAccessToken(json_encode($google_client_token));
                // Запросим контакты пользователя
                $service = new Google_Service_People($client);

                $optParams = array('requestMask.includeField' => 'person.phone_numbers,person.names,person.email_addresses');
                $results = $service->people_connections->listPeopleConnections('people/me',$optParams);

                $contacts = [];
                foreach($results->connections as $connection)
                {
                    $contact = [];
                    if(isset($connection->names))
                    {
                        $contact['name'] = $connection->names[0]->displayName;
                    }

                    if(isset($connection->phoneNumbers))
                    {
                        $contact['phone'] = $connection->phoneNumbers[0]->canonicalForm;
                    }

                    if(isset($connection->emailAddresses))
                    {
                        $contact['email'] = $connection->emailAddresses[0]->value;
                    }

                    $contacts[] = $contact;
                }
                $providerUser->contacts = $contacts;
            }

            $nickname = $providerUser->getNickname();
            $user = User::createBySocialProvider($providerUser);

            if($providerName=='twitch')
            {
                $streams = [];
                $data = TwitchHelper::getVideosByUsername($nickname);
                foreach($data as $stream)
                {
                    $streams[] = $stream['url'];
                }

                $user->update([
                    'streams' => $streams
                ]);
            }

            if($providerName=="google")
            {
                $user->update([
                    'contacts' => $providerUser->contacts
                ]);
            }

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
