<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GenreResource extends JsonResource
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
            'giantbomb_id' => $this->giantbomb_id,
            'game_id' => $this->game_id,
            'active' => $this->active,
            'image' => $this->image,
            'desc' => $this->desc,
            'video_count' => $this->video_count,

            'games' => GameResource::collection($this->whenLoaded('games'))
        ];
    }
}
