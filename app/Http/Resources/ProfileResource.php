<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\GameResource;
use App\Http\Resources\TeamResource;

class ProfileResource extends JsonResource
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
            'type' => $this->type,
            'user_id' => $this->user_id,
            'game_id' => $this->game_id,
            'nickname' => $this->nickname,
            'link' => $this->link,
            'rank' => $this->link,
            'streaming_link' => $this->streaming_link,
            'peak_rank' => $this->peak_rank,
            'additional_link' => $this->additional_link,
            'rank_image' => $this->rank_image,
            'progress' => $this->progress,
            'have_banned' => $this->have_banned,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

            'user' => new UserResource($this->whenLoaded('user')),
            'game' => new GameResource($this->whenLoaded('game')),
            'teams' => TeamResource::collection($this->whenLoaded('teams')),
        ];
    }
}
