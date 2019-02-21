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
    protected $fillable = ['udata_id', 'profile_id', 'vacancy_id', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function udata()
    {
        return $this->belongsTo('App\Models\Udata');
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
    public function vacancy()
    {
        return $this->belongsTo('App\Models\Vacancy');
    }
}
