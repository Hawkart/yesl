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
            'cover' => $this->cover ? Storage::disk('public')->url($this->cover) : '/img/top_header2.jpg',
            'owner_id' => $this->owner_id,
            'description' => $this->description,
            'groupable_type' => $this->groupable_type,
            'groupable_id' => $this->groupable_id,
            'coach_name' => $this->coach_name,
            'coach_last_name' => $this->coach_last_name,
            'coach_email' => $this->coach_email,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'owner' => new UserResource($this->whenLoaded('owner')),
            'posts' => PostResource::collection($this->whenLoaded('posts')),
        ];
    }
}
