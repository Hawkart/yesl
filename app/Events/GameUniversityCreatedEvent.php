<?php

namespace App\Events;

use App\Models\GameUniversity;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class GameUniversityCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $gameUniversity;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\GameUniversity $gameUniversity
     */
    public function __construct(GameUniversity $gameUniversity)
    {
        $this->gameUniversity = $gameUniversity;
    }
}