<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\University;
use App\Models\Game;

class Group extends Model
{
    use Sluggable;

    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = ['title', 'image', 'cover', 'owner_id', 'description', 'groupable_type', 'groupable_id', 'slug'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * Get all of the owning groupable models.
     */
    public function groupable()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the owning groupable models.
     */
    public function university()
    {
        return $this->belongsTo(University::class, 'groupable_id')
            ->where('groups.groupable_type', University::class);
    }

    /**
     * Get all of the owning groupable models.
     */
    public function game()
    {
        return $this->belongsTo(Game::class, 'groupable_id')
            ->where('groups.groupable_type', Game::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'group_users');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'group_id');
    }

    /**
     * Search by params
     */
    public function scopeSearch($query, $request)
    {
        if(!empty($request['id']))
        {
            $query->where('id', (int)$request['id']);
        }
        if(!empty($request['q']))
        {
            $query->where('title', 'like', "%".$request['q']."%");
        }
        if(!empty($request['state']))
        {
            $query->whereHas('university', function($q) use ($request){
                $q->where('state', $request['state']);
            });
        }

        if(!empty($request['major_id']))
        {
            $query->whereHas('university', function($q) use ($request){
                $q->whereHas('majors', function($qq) use ($request){
                    $qq->where('major_id', $request['major_id']);
                });
            });
        }

        if(!empty($request['in_state']) && $request['in_state']=='on')
        {
            $query->whereHas('university', function($q){
                $q->whereRaw('cost_tuition_in_state < cost_tuition_out_of_state') ;
            });

            if(!empty($request['tution_from']) && !empty($request['tution_to']))
            {
                $query->whereHas('university', function($q) use ($request){
                    $q->whereBetween('cost_tuition_in_state', [$request['tution_from'], $request['tution_to']]);
                });
            }

        }else{
            if(!empty($request['tution_from']) && !empty($request['tution_to']))
            {
                $query->whereHas('university', function($q) use ($request){
                    $q->whereBetween('cost_tuition_out_of_state', [$request['tution_from'], $request['tution_to']]);
                });
            }
        }

        if(!empty($request['sat_from']) && !empty($request['sat_to']))
        {
            $query->whereHas('university', function($q) use ($request){
                $q->whereBetween('sat_scores_average_overall', [$request['sat_from'], $request['sat_to']])
                    ->orWhereNull('sat_scores_average_overall');
            });
        }

        if(!empty($request['genre_id']))
        {
            $query->whereHas('game', function($q) use ($request){
                $q->where('genre_id', $request['genre_id']);
            });
        }
        return $query;
    }
}