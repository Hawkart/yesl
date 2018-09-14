<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $profile_id
 * @property int $team_id
 * @property int $sender_id
 * @property boolean $status
 * @property string $start_at
 * @property string $end_at
 * @property string $created_at
 * @property string $updated_at
 * @property Profile $profile
 * @property Profile $profile
 * @property Team $team
 */
class ProfileTeam extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'profile_team';

    /**
     * @var array
     */
    protected $fillable = ['profile_id', 'team_id', 'sender_id', 'status', 'start_at', 'end_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo('App\Models\Profile');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo('App\Models\Profile', 'sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }
}
