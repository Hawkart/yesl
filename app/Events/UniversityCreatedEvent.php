<?php

namespace App\Events;

use App\Models\University;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UniversityCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $university;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\University $university
     */
    public function __construct(University $university)
    {
        $this->university = $university;
    }
}