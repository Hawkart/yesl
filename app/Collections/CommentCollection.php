<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

class CommentCollection extends Collection
{
    public function threaded()
    {
        $comments = parent::groupBy('reply_id');
        if (count($comments)) {
            $comments['root'] = $comments[''];
            unset($comments['']);
        }
        return $comments;
    }
}