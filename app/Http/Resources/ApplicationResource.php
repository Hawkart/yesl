<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UniversityResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\GroupResource;
use App\Http\Resources\ProfileResource;
use Storage;

class ApplicationResource extends JsonResource
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
            'profile_id' => $this->profile_id,
            'user_id' => $this->user_id,
            'team_id' => $this->team_id,
            'status' => $this->status,
            'message' => $this->message,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'profile' => new ProfileResource($this->whenLoaded('profile')),
            'user' => new UserResource($this->whenLoaded('user')),
            'team' => new TeamResource($this->whenLoaded('team')),
        ];
    }
}
