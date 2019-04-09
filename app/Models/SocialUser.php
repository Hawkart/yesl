<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SocialUser extends Model
{
    protected $table = 'social_users';
    protected $fillable = ['user_id', 'provider_user_id', 'provider', 'json'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'json' => 'array'
    ];

    /**
     * @Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
