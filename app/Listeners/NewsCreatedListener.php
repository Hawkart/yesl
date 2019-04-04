<?php

namespace App\Listeners;

use App\Events\NewsCreatedEvent;
use App\Models\Post;

class NewsCreatedListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\NewsCreatedEvent $event
     * @return mixed
     */
    public function handle(NewsCreatedEvent $event)
    {
        $post = $event->post;

        if(intval($post->status)==1)
            Post::createFromNews($post);
    }
}
