<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $thread_id
 * @property int $user_id
 * @property string $body
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Message extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['thread_id', 'user_id', 'body', 'created_at', 'updated_at', 'deleted_at'];

}
