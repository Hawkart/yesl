<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $game_id
 * @property string $title
 * @property string $image
 * @property Game $game
 */
class GameRole extends Model
{
    public $timestamps = false;
    protected $table = 'game_roles';

    /**
     * @var array
     */
    protected $fillable = ['game_id', 'title', 'image'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game()
    {
        return $this->belongsTo('App\Models\Game');
    }
}
