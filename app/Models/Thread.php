<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $thread_id
 * @property int $threadable_id
 * @property string $threadable_type
 */
class Thread extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

}
