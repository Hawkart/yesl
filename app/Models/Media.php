<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = ['model_id', 'model_type', 'collection_name', 'name', 'file_name', 'mime_type', 'disk',
        'size', 'manipulations', 'custom_properties', 'responsive_images', 'order_column'];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'manipulations' => 'array',
        'responsive_images' => 'array',
        'custom_properties' => 'array'
    ];
}