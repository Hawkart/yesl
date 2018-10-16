<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Auth;

class UsersResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        // Eager load
        //$this->resource->load('posts');

        $user = Auth::user();

        return $this->resource->map(function ($item) use ($user) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'nickname' => $item->nickname,
                'email' => ($user->id==$item->id) ? $item->email : '',
                'posts' => PostsResource::collection($this->whenLoaded('posts'))
            ];
        });
    }
}