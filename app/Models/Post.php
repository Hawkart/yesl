<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Carbon\Carbon;

class Post extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'group_id', 'parent_id', 'text', 'additional'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'additional' => 'array'
    ];

    /**
     * The attributes that should be appended.
     *
     * @var array
     */
    protected $appends = [
        'repostCount'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Post');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reposts()
    {
        return $this->hasMany('App\Models\Post', 'parent_id');
    }

    /**
     * @return int
     */
    public function getRepostCountAttribute()
    {
        return $this->reposts()->count();
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');//->whereNull('reply_id');
    }

    /**
     * Get media
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function media()
    {
        return $this->morphMany('App\Models\Media', 'model');
    }

    /**
     * @param $post
     */
    public function createFromNews($post)
    {
        $text = $post->title;

        if(!empty($post->subtitle))
            $text.="<br>".$post->subtitle;

        $text.="<br>".$post->body;

        $data = [
            'user_id' => 16,
            'group_id' => 0,
            'text' => $text,
            'created_at' => Carbon::parse($post->created_at)
        ];

        if($result = Post::create($data))
        {
            if(!empty($post->image))
            {
                $result
                    ->addMedia(public_path($post->image))
                    ->toMediaCollection('images');
            }
        }
    }
}
