<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $game_id
 * @property int $created_id
 * @property int $judge_id
 * @property int $commentator_id
 * @property int $cancel_user_id
 * @property int $created_team_id
 * @property int $tournament_id
 * @property string $title
 * @property int $count_parts
 * @property string $start_at
 * @property string $end_at
 * @property int $winner_id
 * @property string $result
 * @property boolean $changed_time
 * @property string $cancel_text
 * @property float $bet
 * @property boolean $status
 * @property string $extern_match_id
 * @property string $extern_statistic
 * @property int $tournament_step
 * @property string $created_at
 * @property string $updated_at
 * @property Profile $profile
 * @property User $user
 * @property Profile $profile
 * @property Team $team
 * @property Game $game
 * @property User $user
 * @property Tournament $tournament
 * @property FightTeam[] $fightTeams
 */
class Fight extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['game_id', 'created_id', 'judge_id', 'commentator_id', 'cancel_user_id', 'created_team_id', 'tournament_id', 'title', 'count_parts', 'start_at', 'end_at', 'winner_id', 'result', 'changed_time', 'cancel_text', 'bet', 'status', 'extern_match_id', 'extern_statistic', 'tournament_step', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo('App\Models\Profile', 'cancel_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'commentator_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo('App\Models\Profile', 'created_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo('App\Models\Team', 'created_team_id');
    }

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
        return $this->belongsTo('App\Models\User', 'judge_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tournament()
    {
        return $this->belongsTo('App\Models\Tournament');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fightTeams()
    {
        return $this->hasMany('App\Models\FightTeam');
    }
}
