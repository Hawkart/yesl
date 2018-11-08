<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\University;
use App\Models\Game;

class Group extends Model
{
    use Sluggable;

    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = ['title', 'image', 'cover', 'owner_id', 'description', 'groupable_type', 'groupable_id', 'slug'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * Get all of the owning groupable models.
     */
    public function groupable()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the owning groupable models.
     */
    public function university()
    {
        return $this->belongsTo(University::class, 'groupable_id')
            ->where('groups.groupable_type', University::class);
    }

    /**
     * Get all of the owning groupable models.
     */
    public function game()
    {
        return $this->belongsTo(Game::class, 'groupable_id')
            ->where('groups.groupable_type', Game::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'group_users');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'group_id');
    }

    /**
     * Search by params
     */
    public function scopeSearch($query, $request)
    {
        if(!empty($request['id']))
        {
            $query->where('id', (int)$request['id']);
        }
        if(!empty($request['q']))
        {
            $query->where('title', 'like', "%".$request['q']."%");
        }
        if(!empty($request['state']))
        {
            $query->whereHas('university', function($q) use ($request){
                $q->where('state', $request['state']);
            });
        }
        if(!empty($request['genre_id']))
        {
            $query->whereHas('game', function($q) use ($request){
                $q->where('genre_id', $request['genre_id']);
            });
        }
        return $query;
    }
}