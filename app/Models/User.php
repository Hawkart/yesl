<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use TCG\Voyager\Models\User as VoyagerUser;
use Cmgmyr\Messenger\Traits\Messagable;
use Hootlex\Friendships\Traits\Friendable;
use Carbon\Carbon;
use Cache;
use File;
use Image;

class User extends VoyagerUser
{
    use Notifiable, Messagable, Friendable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_id', 'name', 'email', 'avatar', 'password', 'remember_token',
        'settings', 'created_at', 'updated_at', 'api_token', 'first_name', 'last_name',
        'second_name', 'nickname', 'verified', 'confirmation_code', 'notify', 'overlay',
        'description', 'timezone', 'contacts', 'university_id', 'date_birth', 'gender'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token', 'confirmation_code'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date_birth'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'contacts' => 'array',
        'settings' => 'array'
    ];

    /**
     * Boot the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($user)
        {
            if(empty($user->nickname))
                $user->nickname = substr($user->email, 0,strrpos($user->email, '@'));

            if(empty($user->name))
                $user->name = trim($user->first_name." ".$user->last_name);

            if(empty($user->api_token))
                $user->api_token = str_random(100);
        });
    }

    public function verified()
    {
        $this->verified = 1;
        $this->confirmation_code = null;
        $this->save();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @Relation
     */
    public function university()
    {
        return $this->belongsTo('App\Models\University');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'author_id');
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
    public function socialAccounts()
    {
        return $this->hasMany('App\Models\UserSocialAccount');
    }

    /**
     * User is judge of fights
     * @Relation
     */
    public function judgeOfFights()
    {
        return $this->hasMany('App\Models\Fight', 'judge_id');
    }

    /**
     * User is commentator of fights
     * @Relation
     */
    public function commentatorOfFights()
    {
        return $this->hasMany('App\Models\Fight', 'commentator_id');
    }
}
