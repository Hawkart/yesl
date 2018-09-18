<?php

namespace App\Events;

use App\Models\Profile;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ProfileCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $profile;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Profile $profile
     */
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }
}