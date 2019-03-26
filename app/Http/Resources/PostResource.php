<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\GroupResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'user_id' => $this->user_id,
            'group_id' => $this->group_id,
            'parent_id' => $this->parent_id,
            'additional' => $this->additional,

            'user' => new UserResource($this->whenLoaded('user')),
            'group' => new GroupResource($this->whenLoaded('group')),
            'parent' => new PostResource($this->whenLoaded('parent')),
            'reposts' => PostResource::collection($this->whenLoaded('reposts')),
        ];
    }
}
