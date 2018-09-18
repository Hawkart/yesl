<?php

namespace App\Events;

use App\Models\Game;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class GameCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $game;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Game $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }
}