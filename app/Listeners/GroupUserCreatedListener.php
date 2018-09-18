<?php

namespace App\Listeners;

use App\Events\GroupUserCreatedEvent;
use App\Models\Profile;

class GroupUserCreatedListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\GroupUserCreatedEvent $event
     * @return mixed
     */
    public function handle(GroupUserCreatedEvent $event)
    {
        $groupUser = $event->groupUser;
        $user = $groupUser->user;
        $group = $groupUser->group;
        $groupable = $group->groupable;

        app('log')->info($groupable);

        if($groupable instanceof \App\Models\Game)
        {
            if(Profile::where('user_id', $user->id)->where('game_id', $groupable->id)->count()==0)
            {
                $profile = $user->profiles()->create([
                    'game_id' => $groupable->id
                ]);
            }
        }
    }
}