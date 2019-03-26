<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'post_id' => $this->profile_id,
            'user_id' => $this->user_id,
            'reply_id' => $this->team_id,
            'comment' => $this->status,
            'additional' => $this->message,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'post' => new PostResource($this->whenLoaded('post')),
            'user' => new UserResource($this->whenLoaded('user')),
            'reply' => new PostResource($this->whenLoaded('reply')),
        ];
    }
}
