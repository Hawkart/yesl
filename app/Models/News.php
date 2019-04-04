<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];


    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => \App\Events\NewsCreatedEvent::class,
        'updated' => \App\Events\NewsUpdatedEvent::class,
    ];

    /**
     * @Relation
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'author_id');
    }
}
