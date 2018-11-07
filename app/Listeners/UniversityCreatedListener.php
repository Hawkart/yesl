<?php

namespace App\Listeners;

use App\Events\UniversityCreatedEvent;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UniversityCreatedListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\UniversityCreatedEvent $event
     * @return mixed
     */
    public function handle(UniversityCreatedEvent $event)
    {
        $university = $event->university;

        if(!$user = Auth::user())
            $user = User::where('role_id', 1)->first();

        $group = Group::create([
            'title' => $university->title,
            'owner_id' => $user->id,
            'groupable_type' => 'App\Models\University',
            "groupable_id" => $university->id
        ]);

        $user->groups()->attach($group->id);
    }
}