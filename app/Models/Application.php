<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    const STATUS_PENDING = 0;
    const STATUS_INVITE = 1;
    const STATUS_IGNORE = 2;
    const STATUS_FUTHER = 3;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'profile_id', 'team_id', 'status', 'message'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo('App\Models\Profile');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }

    /**
     * @param $status
     * @return mixed
     */
    public static function getStatusTitle($status)
    {
        $statuses = [
            0 => 'Pending',
            1 => 'Invited',
            2 => 'Ignored',
            3 => 'Futher'
        ];

        return $statuses[$status];
    }

    /**
     * Search by params
     */
    public function scopeSearch($query, $request)
    {
        if(!empty($request['game_id']))
        {
            $query->where('game_id', $request['game_id']);
        }
        return $query;
    }
}
