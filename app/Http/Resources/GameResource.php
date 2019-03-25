<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\GroupResource;
use App\Http\Resources\GenreResource;
use Storage;

class GameResource extends JsonResource
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
            'type' => $this->text,
            'active' => $this->active,
            'logo_mini' => $this->logo_mini ? Storage::disk('public')->url($this->logo_mini) : '',
            'logo' => $this->logo ? Storage::disk('public')->url($this->logo) : '/img/university-logo-default.jpg',//$this->logo,
            'images' => $this->images,
            'genre_id' => $this->genre_id,
            'giantbomb_id' => $this->giantbomb_id,
            'twitch_id' => $this->twitch_id,
            'alias' => $this->alias,
            'body' => $this->body,
            'site_url' => $this->site_url,
            'rules' => $this->rules,
            'video_count' => $this->video_count,
            'online' => $this->online,
            'min_players' => $this->min_players,
            'overlay' => $this->overlay,
            'cross_block' => $this->cross_block,
            'social_provider' => $this->social_provider,

            'group' => new GroupResource($this->whenLoaded('group')),
            'genre' => new GenreResource($this->whenLoaded('genre')),
            'roles' => GameRoleResource::collection($this->whenLoaded('roles')),
            'profiles' => ProfileResource::collection($this->whenLoaded('profiles')),
            //'fights' => FightResource::collection($this->whenLoaded('fights')),
            'tournaments' => TournamentResource::collection($this->whenLoaded('tournaments')),
            'teams' => TeamResource::collection($this->whenLoaded('teams')),
            'universities' => UniversityResource::collection($this->whenLoaded('universities')),
        ];
    }
}
