<?php

namespace App\Events;

use App\Models\News;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class NewsUpdatedEvent
{
    use Dispatchable, SerializesModels;

    public $post;

    /**
     * Create a new event instance.
     *
     * @param \App\\ModelsNews $post
     */
    public function __construct(News $post)
    {
        $this->post = $post;
    }
}
