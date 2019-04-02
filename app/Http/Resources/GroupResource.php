<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
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

            'groupable' => $this->getGroupable(),
            'owner' => new UserResource($this->whenLoaded('owner')),
            'posts' => PostResource::collection($this->whenLoaded('posts')),
        ];
    }

    /**
     * @return array
     */
    private function getGroupable()
    {
        if(!empty($this->groupable_type))
        {
            $string = explode('\\', $this->groupable_type);
            $str = $string[count($string)-1];
            $cname = "App\\Http\\Resources\\".$str."Resource";

            return new $cname($this->whenLoaded('groupable'));
        }else{
            return [];
        }
    }
}
