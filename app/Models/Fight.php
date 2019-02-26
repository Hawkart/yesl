<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    public function created()
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
    public function referee()
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
