<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $genre_id
 * @property boolean $active
 * @property int $giantbomb_id
 * @property int $twitch_id
 * @property string $title
 * @property string $alias
 * @property string $images
 * @property string $logo
 * @property string $body
 * @property string $site_url
 * @property string $rules
 * @property int $video_count
 * @property boolean $online
 * @property int $min_players
 * @property string $overlay
 * @property int $cross_block
 * @property string $social_provider
 * @property string $logo_mini
 * @property Genre $genre
 * @property Fight[] $fights
 * @property GameRole[] $gameRoles
 * @property Profile[] $profiles
 * @property Tournament[] $tournaments
 */
class Game extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['genre_id', 'active', 'giantbomb_id', 'twitch_id', 'title', 'alias', 'images', 'logo', 'body', 'site_url', 'rules', 'video_count', 'online', 'min_players', 'overlay', 'cross_block', 'social_provider', 'logo_mini'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function genre()
    {
        return $this->belongsTo('App\Models\Genre');
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
    public function gameRoles()
    {
        return $this->hasMany('App\Models\GameRole');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profiles()
    {
        return $this->hasMany('App\Models\Profile');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tournaments()
    {
        return $this->hasMany('App\Models\Tournament');
    }
}
