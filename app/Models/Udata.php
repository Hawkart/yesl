<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Udata extends Model
{
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications()
    {
        return $this->hasMany('App\Models\Application');
    }
}
