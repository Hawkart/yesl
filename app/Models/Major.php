<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function universities()
    {
        return $this->belongsToMany('App\Models\University');
    }

    /**
     * Search by params
     */
    public function scopeSearch($query, $request)
    {
        if(!empty($request['title']))
        {
            $query->where('title', 'like', "%".$request['title']."%");
        }

        return $query;
    }
}
