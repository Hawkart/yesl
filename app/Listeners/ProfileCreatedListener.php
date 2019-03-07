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
        $userGroups = $user->groups()->pluck('group_id')->toArray();

        if(!in_array($game->group->id, $userGroups))
            $groups[] = $game->group->id;

        if(intval($user->university_id)>0)
        {
            if(!in_array($user->university->group->id, $userGroups))
                $groups[] = $user->university->group->id;

            $gu = GameUniversity::where("university_id", $user->university_id)
                                    ->where('game_id', $game->id);

            if($gu->count()>0 && !in_array($gu->first()->group->id, $userGroups))
                $groups[] = $gu->first()->group->id;
        }

        $user->groups()->attach($groups);
    }
}
