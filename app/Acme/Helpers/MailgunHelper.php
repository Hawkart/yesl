<?php

namespace App\Acme\Helpers;

use Cache;
use Mail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MailgunHelper{

    public static function create($params)
    {
        if(getenv('APP_ENV')=='production') {
            // New Account
            $username = 'bitrix';
            $domain = getenv('MAILGUN_DOMAIN', '');

            // Prepare POST query
            $postvars = array(
                'user' => getenv('VESTA_USERNAME', ''),
                'password' => getenv('VESTA_PASSWORD', ''),
                'returncode' => 'yes',
                'cmd' => 'v-add-mail-account',
                'arg1' => $username,
                'arg2' => $domain,
                'arg3' => $params['account'],
                'arg4' => $params['password']
            );

            // Send POST query via cURL
            $postdata = http_build_query($postvars);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://' . getenv('VESTA_HOSTNAME', '') . ':' . getenv('VESTA_PORT', '') . '/api/');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
            $answer = curl_exec($curl);

            // Check result
            if ($answer == 0) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    public static function send($params = [])
    {
        $user = Auth::user();

        $result = Mail::raw($params['body'], function($message)  use ($user, $params)
        {
            $message->to($params['to'])
                ->from($user->email, $user->name)
                ->replyTo($user->email, $user->name)
                ->subject($params['subject']);

            if(isset($params['attachments']) && count($params['attachments'])>0)
            {
                foreach($params['attachments'] as $path)
                {
                    $message->attach($path);
                }
            }
        });

        return $result;
    }

    public static function send2()
    {
        $user = Auth::user();

        $result = Mail::raw('Sending emails with Mailgun and Laravel is easy!', function($message)  use ($user)
        {
            $message->subject('Mailgun and Laravel are awesome!')
                    ->from("info@yesl.tv", $user->name)
                    ->replyTo("info@yesl.tv", $user->name)
                    ->to("hawkart@rambler.ru");
        });

        dd($result);

        return $result;
    }
}