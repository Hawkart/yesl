<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $game_id
 * @property int $user_id
 * @property string $nickname
 * @property boolean $type
 * @property string $created_at
 * @property string $updated_at
 * @property Game $game
 * @property User $user
 * @property Fight[] $fights
 * @property Fight[] $fights
 * @property ProfileTeam[] $profileTeams
 * @property ProfileTeam[] $profileTeams
 * @property Team[] $teams
 */
class Profile extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['game_id', 'user_id', 'nickname', 'type', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game()
    {
        return $this->belongsTo('App\Models\Game');
    }

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
    public function fights()
    {
        return $this->hasMany('App\Models\Fight', 'cancel_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fights()
    {
        return $this->hasMany('App\Models\Fight', 'created_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profileTeams()
    {
        return $this->hasMany('App\Models\ProfileTeam');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profileTeams()
    {
        return $this->hasMany('App\Models\ProfileTeam', 'sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teams()
    {
        return $this->hasMany('App\Models\Team', 'coach_id');
    }
}
