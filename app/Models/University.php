<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class University extends Model
{
    use Sluggable;

    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = ['title', 'url', 'json', 'address', 'domain', 'slug'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'json' => 'array'
    ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => \App\Events\UniversityCreatedEvent::class,
    ];

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teams()
    {
        return $this->hasMany('App\Models\Team');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function games()
    {
        return $this->belongsToMany('App\Models\Game');
    }

    /**
     * Get group of university
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function group()
    {
        return $this->morphOne('App\Models\Group', 'groupable');
    }
}
