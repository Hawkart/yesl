<?php

namespace App\Listeners;

use App\Events\GameUniversityCreatedEvent;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GameUniversityCreatedListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\GameUniversityCreatedEvent $event
     * @return mixed
     */
    public function handle(GameUniversityCreatedEvent $event)
    {
        /*$gameUniversity = $event->gameUniversity;

        if(!$user = Auth::user())
            $user = User::where('role_id', 1)->first();

        $group = Group::create([
            'title' => $gameUniversity->university->title.". ".$gameUniversity->game->title,
            'owner_id' => $user->id,
            'groupable_type' => 'App\Models\GameUniversity',
            "groupable_id" => $gameUniversity->id
        ]);

        $user->groups()->attach($group->id);*/
    }
}
