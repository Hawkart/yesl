<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = ['from', 'group_id', 'body'];
}
