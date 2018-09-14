<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string $comment
 * @property int $active
 * @property int $reply_id
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 * @property Post $post
 * @property User $user
 */
class Comment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['post_id', 'user_id', 'comment', 'active', 'reply_id', 'url', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
