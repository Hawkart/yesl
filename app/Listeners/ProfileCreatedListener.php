<?php

namespace App\Listeners;

use App\Events\ProfileCreatedEvent;
use App\Models\Group;
use App\Models\GameUniversity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileCreatedListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\ProfileCreatedEvent $event
     * @return mixed
     */
    public function handle(ProfileCreatedEvent $event)
    {
        $profile = $event->profile;
        $user = $profile->user;
        $game = $profile->game;

        $groups = [];
        $groups[] = $game->group()->first()->id;

        if(intval($user->university_id)>0)
        {
            $groups[] = $user->university->group()->first()->id;

            $gu = GameUniversity::where("university_id", $user->university_id)
                                    ->where('game_id', $game->id);

            if($gu->count()>0)
            {
                $groups[] = $gu->first()->group()->first()->id;
            }
        }

        $user->groups()->attach($groups);
    }
}