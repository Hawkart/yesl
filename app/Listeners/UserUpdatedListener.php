<?php

namespace App\Listeners;

use App\Events\UserUpdatedEvent;
use Carbon\Carbon;

class UserUpdatedListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\UserUpdatedEvent $event
     * @return mixed
     */
    public function handle(UserUpdatedEvent $event)
    {
        $user = $event->user;

        app('log')->info($user);

        if($user->isDirty('verified'))
        {
            if($user->verified!==$user->getOriginal('verified') && intval($user->university_id)>0)
            {
                $group = $user->university()->first()->group()->first();
                $user->groups()->attach($group->id);
            }
        }
    }
}