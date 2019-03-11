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
// These two come from Media Library
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Hootlex\Friendships\Models\Friendship;
use Cviebrock\EloquentSluggable\Sluggable;

class User extends VoyagerUser implements HasMedia
{
    use Notifiable, Messagable, Friendable, HasMediaTrait, Sluggable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
        'settings' => 'array',
        'experience' => 'array'
    ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'updated' => \App\Events\UserUpdatedEvent::class,
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'nickname' => [
                'source' => 'name'
            ]
        ];
    }

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
            //if(empty($user->nickname))
                //$user->nickname = trim($user->first_name." ".$user->last_name);

            if(empty($user->name))
                $user->name = trim($user->first_name." ".$user->last_name);

            if(empty($user->api_token))
                $user->api_token = str_random(100);
        });
    }

    /**
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     *
     * example: Auth::user()->getMedia('avatars')->first()->getUrl('thumb')
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(50)
            ->height(50);
    }

    public function setDateBirthAttribute( $value ) {
        $this->attributes['date_birth'] = (new Carbon($value))->format('Y-m-d');
    }

    /**
     * Verify user after confirmation of email.
     */
    public function verify()
    {
        $this->verified = 1;
        $this->confirmation_code = null;
        $this->save();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany('App\Models\Group');
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

    /**
     * Search by params
     */
    public function scopeSearch($query, $request)
    {
        if(!empty($request['q']))
        {
            $query->where('name', 'like', "%".$request['q']."%");
        }
        return $query;
    }

    /**
     * Admins
     */
    public function scopeAdmins($query)
    {
        $query->where('role_id', 1);
        return $query;
    }

    /**
     * Admins
     */
    public function scopeSimpleUsers($query)
    {
        $query->where('role_id', 2);
        return $query;
    }

    /**
     * Verified users
     */
    public function scopeVerified($query)
    {
        $query->where('verified', 1);
        return $query;
    }

    /**
     * Athletes
     */
    public function scopeAthletes($query)
    {
        $query->where('type', 1);
        return $query;
    }

    /**
     * Coaches
     */
    public function scopeCoaches($query)
    {
        $query->where('type', 2);
        return $query;
    }

    /**
     * @return bool
     */
    public function isAthlete()
    {
        return ($this->type==1);
    }

    /**
     * @return bool
     */
    public function isCoach()
    {
        return ($this->type==2);
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return ($this->role_id==1);
    }

    /**
     * @return bool
     */
    public function isVerified()
    {
        return ($this->verified==1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Friendship[]
     */
    public function getPendingIncomingFriends($status = null)
    {
        $query = Friendship::whereRecipient($this);

        if (!is_null($status)) {
            $query->where('status', $status);
        }

        return $query;
    }
    /**
     * @return \Illuminate\Database\Eloquent\Collection|Friendship[]
     */
    public function getPendingOutgoingFriends($status = null)
    {
        $query = Friendship::whereSender($this);

        if (!is_null($status)) {
            $query->where('status', $status);
        }

        return $query;
    }
}
