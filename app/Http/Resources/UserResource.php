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

class UserResource extends JsonResource
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
            'name' => $this->name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'second_name' => $this->second_name,
            'nickname' => $this->nickname,
            'description' => $this->description,
            'verified' => $this->verified,
            'email' => $this->when(Auth::user() && Auth::user()->id==$this->id, $this->email),
            'role_id' => $this->role_id,
            'avatar' => $this->avatar ? Storage::disk('public')->url($this->avatar) : '',
            'overlay' => $this->overlay ? Storage::disk('public')->url($this->overlay) : '/img/top_header2.jpg',
            'confirmation_code' => $this->confirmation_code,
            'notify' => $this->notify,
            'timezone' => $this->timezone,
            'contacts' => $this->contacts,
            'university_id'  => $this->university_id,
            'date_birth'  => $this->date_birth ? substr((string) $this->date_birth, 0 ,10) : '',
            'gender'  => $this->gender,
            'type'  => $this->type,
            'title' => $this->title,
            'season_in_row' => $this->season_in_row,
            'alma_mater' => $this->alma_mater,
            'experience' => $this->experience,
            'precreated'  => $this->precreated,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'groups' => GroupResource::collection($this->whenLoaded('groups')),
            'profiles' => ProfileResource::collection($this->whenLoaded('profiles')),
            'posts' => PostResource::collection($this->whenLoaded('posts')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'university' => new UniversityResource($this->whenLoaded('university')),
        ];
    }
}
