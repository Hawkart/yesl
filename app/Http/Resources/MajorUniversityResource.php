<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MajorUniversityResource extends JsonResource
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
            'major_id' => $this->major_id,
            'university_id' => $this->university_id,

            'major' => new MajorResource($this->whenLoaded('major')),
            'university' => new UniversityResource($this->whenLoaded('university'))
        ];
    }
}
