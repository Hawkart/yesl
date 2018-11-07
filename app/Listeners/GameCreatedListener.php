<?php

namespace App\Listeners;

use App\Events\GameCreatedEvent;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GameCreatedListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\GameCreatedEvent $event
     * @return mixed
     */
    public function handle(GameCreatedEvent $event)
    {
        $game = $event->game;

        if(!$user = Auth::user())
            $user = User::where('role_id', 1)->first();

        $group = Group::create([
            'title' => $game->title,
            'image' => $game->logo,
            'owner_id' => $user->id,
            'groupable_type' => 'App\Models\Game',
            "groupable_id" => $game->id
        ]);

        $user->groups()->attach($group->id);
    }
}