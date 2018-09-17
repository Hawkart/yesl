<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['active', 'giantbomb_id', 'title', 'image', 'desc', 'video_count'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function games()
    {
        return $this->hasMany(Game::class)
            ->active()
            ->orderBy('id', 'DESC');
    }
}