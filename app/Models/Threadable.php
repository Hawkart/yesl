<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $thread_id
 * @property int $threadable_id
 * @property string $threadable_type
 */
class Threadable extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['thread_id', 'threadable_id', 'threadable_type'];

}
