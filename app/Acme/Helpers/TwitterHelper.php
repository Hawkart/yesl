<?php

namespace App\Acme\Helpers;

use Cache;
use Carbon\Carbon;

class TwitterHelper{

    static public function getByStr($str, $limit=5)
    {
        $names = explode(",", $str);

        $list = [];
        foreach($names as $name)
        {
            $name = trim($name);
            if(!empty($name))
                $list = array_merge($list, self::getList($name));
        }

        if(count($list)>0) {
            $list = collect($list)->sortByDesc(function ($temp, $key) {
                return Carbon::parse($temp['created_at'])->getTimestamp();
            })->all();
        }

        $list = array_slice($list, 0, $limit);

        foreach($list as &$item)
        {
            $urls = $item['entities']['urls'];

            if(count($urls)>0)
            {
                foreach($urls as $url)
                {
                    $item['text'] = str_replace($url['url'], '<a href="'.$url['url'].'" target="_blank" class="link-post">'.$url['url'].'</a>', $item['text']);
                }
            }
        }

        return $list;
    }

    /**
     * Get twits of user
     *
     * @return mixed
     */
    static public function getList($username)
    {
        $cacheTags = Cache::tags(['twitter']);

        if ($cacheTags->get($username)){
            return $cacheTags->get($username);
        } else {
            $tweets = [];

            $settings = array(
                'oauth_access_token' => env("TWITTER_API_TOKEN", ""),
                'oauth_access_token_secret' => env("TWITTER_API_TOKEN_SECRET", ""),
                'consumer_key' => env("TWITTER_API_CONSUMER_KEY", ""),
                'consumer_secret' => env("TWITTER_API_CONSUMER_SECRET", ""),
            );
            $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
            $requestMethod = "GET";

            $count = 10;
            $getfield = "?screen_name=".$username."&count=".$count;
            $twitter = new \TwitterAPIExchange($settings);

            try {
                $request = $twitter->setGetfield($getfield)
                    ->buildOauth($url, $requestMethod)
                    ->performRequest();
                $tweets = json_decode($request, true);
                if (array_key_exists("errors", $tweets))
                    $tweets = [];   //$tweets[errors][0]["message"]
            }catch (Exception $ex) {
                //echo $ex->getMessage();
            }

            $cacheTags->put($username, $tweets, 5);
            return $tweets;
        }
    }
}