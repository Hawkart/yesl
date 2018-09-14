<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $provider_user_id
 * @property string $provider
 * @property string $json
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class UserSocialAccount extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'user_social_account';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'provider_user_id', 'provider', 'json', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
