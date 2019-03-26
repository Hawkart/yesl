<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            'university_id' => $this->university_id,
            'game_id' => $this->game_id,

            'university' => new UniversityResource($this->whenLoaded('university')),
            'game' => new GameResource($this->whenLoaded('game'))
        ];
    }
}
