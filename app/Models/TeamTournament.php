<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $tournament_id
 * @property int $team_id
 * @property boolean $place
 * @property string $created_at
 * @property string $updated_at
 * @property Team $team
 * @property Tournament $tournament
 */
class TeamTournament extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'team_tournament';

    /**
     * @var array
     */
    protected $fillable = ['tournament_id', 'team_id', 'place', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tournament()
    {
        return $this->belongsTo('App\Models\Tournament');
    }
}
