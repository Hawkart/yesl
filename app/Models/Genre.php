<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property boolean $active
 * @property int $giantbomb_id
 * @property string $title
 * @property string $image
 * @property string $desc
 * @property int $video_count
 * @property Game[] $games
 */
class Genre extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['active', 'giantbomb_id', 'title', 'image', 'desc', 'video_count'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function games()
    {
        return $this->hasMany('App\Models\Game');
    }
}
