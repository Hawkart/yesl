<?php

namespace App\Events;

use App\Models\News;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class NewsCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $post;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\News $game
     */
    public function __construct(News $post)
    {
        $this->post = $post;
    }
}
