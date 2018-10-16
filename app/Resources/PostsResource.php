<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PostsResource extends Resource
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
                'additional' => $item->additional,
                'parent' => PostsResource::collection($this->whenLoaded('parent')),
                'text' => $item->text,
                'user' => UsersResource::collection($this->whenLoaded('user')),
                'group' => GroupsResource::collection($this->whenLoaded('group')),
            ];
        });
    }
}