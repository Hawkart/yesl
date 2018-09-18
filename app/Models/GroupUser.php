<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group_users';

    /**
     * @var array
     */
    protected $fillable = ['group_id', 'user_id', 'type'];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => \App\Events\GroupUserCreatedEvent::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
