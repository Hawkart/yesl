<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $university_id
 * @property int $author_id
 * @property int $category_id
 * @property string $title
 * @property string $seo_title
 * @property string $excerpt
 * @property string $body
 * @property string $image
 * @property string $slug
 * @property string $meta_description
 * @property string $meta_keywords
 * @property mixed $status
 * @property boolean $featured
 * @property string $created_at
 * @property string $updated_at
 * @property University $university
 * @property Comment[] $comments
 */
class Post extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['university_id', 'author_id', 'category_id', 'title', 'seo_title', 'excerpt', 'body', 'image', 'slug', 'meta_description', 'meta_keywords', 'status', 'featured', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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
}
