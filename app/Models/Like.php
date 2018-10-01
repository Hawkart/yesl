<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = ['user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get all of the owning likable models.
     */
    public function likable()
    {
        return $this->morphTo();
    }
}