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
     * @Relation
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'author_id');
    }
}
