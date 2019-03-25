<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\PostResource;
use Storage;

class GroupResource extends JsonResource
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
            'title' => $this->title,
            'image' => $this->image ? Storage::disk('public')->url($this->image) : '/img/author-main1.jpg',
            'cover' => $this->cover,    //Todo: add link to cover
            'owner_id' => $this->owner_id,
            'description' => $this->description,
            'groupable_type' => $this->groupable_type,
            'groupable_id' => $this->groupable_id,
            'coach_name' => $this->coach_name,
            'coach_last_name' => $this->coach_last_name,
            'coach_email' => $this->coach_email,
            'slug' => $this->slug,
            'owner' => new UserResource($this->whenLoaded('owner')),
            'posts' => PostResource::collection($this->whenLoaded('posts')),
        ];
    }
}
