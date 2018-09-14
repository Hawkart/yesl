<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $coach_id
 * @property string $title
 * @property string $slug
 * @property string $image
 * @property int $capt_id
 * @property int $quantity
 * @property string $overlay
 * @property int $game_id
 * @property boolean $status
 * @property int $count_wins
 * @property int $count_losses
 * @property int $count_fights
 * @property string $schedule
 * @property int $created_id
 * @property int $university_id
 * @property string $created_at
 * @property string $updated_at
 * @property Profile $profile
 * @property FightTeam[] $fightTeams
 * @property Fight[] $fights
 * @property ProfileTeam[] $profileTeams
 * @property TeamTournament[] $teamTournaments
 */
class Team extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['coach_id', 'title', 'slug', 'image', 'capt_id', 'quantity', 'overlay', 'game_id', 'status', 'count_wins', 'count_losses', 'count_fights', 'schedule', 'created_id', 'university_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo('App\Models\Profile', 'coach_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fightTeams()
    {
        return $this->hasMany('App\Models\FightTeam');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fights()
    {
        return $this->hasMany('App\Models\Fight', 'created_team_id');
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
    public function teamTournaments()
    {
        return $this->hasMany('App\Models\TeamTournament');
    }
}
