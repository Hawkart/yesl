<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameUniversityResource extends JsonResource
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
            'university_id' => $this->university_id,
            'game_id' => $this->game_id,

            'game' => new GameResource($this->whenLoaded('group')),
            'university' => new UniversityResource($this->whenLoaded('university'))
        ];
    }
}
