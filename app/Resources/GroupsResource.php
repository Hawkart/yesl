<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class GroupsResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->map(function ($item) {
            return [
                'title' => $item->title,
                'description' => $item->description,
                'image' => $item->image,
                'slug' => $item->slug
            ];
        });
    }
}