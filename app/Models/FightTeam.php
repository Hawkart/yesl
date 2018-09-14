<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $fight_id
 * @property int $team_id
 * @property int $status
 * @property string $extern_match_id
 * @property string $twitch_link
 * @property string $match_result
 * @property Fight $fight
 * @property Team $team
 */
class FightTeam extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fight_team';

    /**
     * @var array
     */
    protected $fillable = ['fight_id', 'team_id', 'status', 'extern_match_id', 'twitch_link', 'match_result'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fight()
    {
        return $this->belongsTo('App\Models\Fight');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }
}
