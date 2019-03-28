<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VarsityUser extends Model
{
    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'varsityusers';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'json' => 'array'
    ];
}
