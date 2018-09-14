<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $game_id
 * @property int $parent_id
 * @property string $title
 * @property string $start_at
 * @property string $end_at
 * @property float $buy_in
 * @property int $prize_pool
 * @property boolean $count_teams
 * @property boolean $min_teams
 * @property boolean $count_wins
 * @property string $description
 * @property string $rules
 * @property string $image
 * @property boolean $is_multiple
 * @property boolean $status
 * @property string $promocode
 * @property string $contract_start_at
 * @property string $contract_end_at
 * @property string $final_at
 * @property string $period
 * @property string $period_start_at
 * @property string $period_final_at
 * @property string $period_register_at
 * @property string $register_start
 * @property string $winners_part
 * @property string $terms
 * @property string $created_at
 * @property string $updated_at
 * @property Game $game
 * @property Fight[] $fights
 * @property TeamTournament[] $teamTournaments
 */
class Tournament extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['game_id', 'parent_id', 'title', 'start_at', 'end_at', 'buy_in', 'prize_pool', 'count_teams', 'min_teams', 'count_wins', 'description', 'rules', 'image', 'is_multiple', 'status', 'promocode', 'contract_start_at', 'contract_end_at', 'final_at', 'period', 'period_start_at', 'period_final_at', 'period_register_at', 'register_start', 'winners_part', 'terms', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game()
    {
        return $this->belongsTo('App\Models\Game');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fights()
    {
        return $this->hasMany('App\Models\Fight');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teamTournaments()
    {
        return $this->hasMany('App\Models\TeamTournament');
    }
}
