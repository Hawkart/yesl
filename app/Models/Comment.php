<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['post_id', 'user_id', 'comment', 'reply_id', 'created_at', 'updated_at'];

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
    public function reply()
    {
        return $this->belongsTo('App\Models\Comment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get likes
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes()
    {
        return $this->morphMany('App\Models\Like', 'likeable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'reply_id');
    }

    /*public function newCollection(array $models = [])
    {
        return new CommentCollection($models);
    }*/
}
