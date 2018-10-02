<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'likeable_type', 'likeable_id'];

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
    public function likeable()
    {
        return $this->morphTo();
    }
}