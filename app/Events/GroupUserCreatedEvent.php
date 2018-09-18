<?php

namespace App\Events;

use App\Models\GroupUser;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class GroupUserCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $groupUser;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\GroupUser $groupUser
     */
    public function __construct(GroupUser $groupUser)
    {
        $this->groupUser = $groupUser;
    }
}