<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameUniversity extends Model
{
    public $timestamps = false;
    protected $table = 'game_universities';

    /**
     * @var array
     */
    protected $fillable = ['game_id', 'university_id'];

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
    public function university()
    {
        return $this->belongsTo('App\Models\University');
    }
}
