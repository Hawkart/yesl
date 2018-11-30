<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Mailbox extends Model
{
    public $timestamps = true;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Mark a thread as read for a user.
     *
     * @param int $userId
     *
     * @return void
     */
    public function markAsRead()
    {
        try {
            $this->last_read = new Carbon();
            $this->save();
        } catch (ModelNotFoundException $e) {
            // do nothing
        }
    }
}
