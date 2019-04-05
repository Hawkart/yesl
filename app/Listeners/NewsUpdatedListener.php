<?php

namespace App\Listeners;

use App\Events\NewsUpdatedEvent;
use App\Models\Post;

class NewsUpdatedListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\NewsUpdatedEvent $event
     * @return mixed
     */
    public function handle(NewsUpdatedEvent $event)
    {
        $post = $event->post;

        if($post->isDirty('status'))
        {
            if($post->status!==$post->getOriginal('status') && intval($post->status)==1)
                Post::createFromNews($post);
        }
    }
}
