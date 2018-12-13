<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MajorUniversity extends Model
{
    public $timestamps = false;
    protected $table = 'major_university';

    /**
     * @var array
     */
    protected $fillable = ['major_id', 'university_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function major()
    {
        return $this->belongsTo('App\Models\Major');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function university()
    {
        return $this->belongsTo('App\Models\University');
    }
}