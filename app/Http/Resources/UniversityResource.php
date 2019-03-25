<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\GroupResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\GameResource;
use App\Http\Resources\MajorResource;
use App\Http\Resources\UserResource;
use Storage;

class UniversityResource extends JsonResource
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
            'nace' => $this->nace,
            'image' => $this->image,        //Todo: add link to image
            'logo' =>  $this->logo ? Storage::disk('public')->url($this->logo) : '/img/university-logo-default.jpg',
            'overlay' => $this->overlay,
            'slug' => $this->slug,
            'es_team_title' => $this->es_team_title,
            'es_team_image' => $this->es_team_image,
            'url' => $this->url,
            'json' => $this->json,
            'domain' => $this->domain,
            'address' => $this->address,
            'score_id' => $this->score_id,
            'ope8_id' => $this->ope8_id,
            'ope6_id' => $this->ope6_id,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'accreditor' => $this->accreditor,
            'price_calculator_url' => $this->price_calculator_url,
            'main_campus' => $this->main_campus,
            'branches' => $this->branches,
            'ownership' => $this->ownership,
            'state_fips' => $this->state_fips,
            'region_id' => $this->region_id,
            'location_lat' => $this->location_lat,
            'location_lon' => $this->location_lon,
            'admission_rate_overall' => $this->admission_rate_overall,
            'sat_scores_average_overall' => $this->sat_scores_average_overall,
            'online_only' => $this->online_only,
            'size' => $this->size,
            'enrollment_all' => $this->enrollment_all,
            'operating' => $this->operating,
            'cost_tuition_in_state' => $this->cost_tuition_in_state,
            'cost_tuition_out_of_state' => $this->cost_tuition_out_of_state,
            'aid_pell_grant_rate' => $this->aid_pell_grant_rate,
            'aid_federal_loan_rate' => $this->aid_federal_loan_rate,
            'demographics_age_entry' => $this->demographics_age_entry,
            'demographics_female_share' => $this->demographics_female_share,
            'demographics_married' => $this->demographics_married,
            '10_yrs_after_entry_working_not_enrolled' => $this->{'10_yrs_after_entry_working_not_enrolled'},
            '10_yrs_after_entry_median' => $this->{'10_yrs_after_entry_median'},
            'demographics_men' => $this->demographics_men,
            'demographics_women' => $this->demographics_women,
            'undergrads_with_pell_grant' => $this->undergrads_with_pell_grant,
            'undergrads_non_degree' => $this->undergrads_non_degree,
            'grad_students' => $this->grad_students,
            'degrees_awarded_highest' => $this->degrees_awarded_highest,
            'twitter_str' => $this->twitter_str,
            'group' => new GroupResource($this->whenLoaded('group')),
            'posts' => PostResource::collection($this->whenLoaded('posts')),
            'teams' => TeamResource::collection($this->whenLoaded('teams')),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'games' => GameResource::collection($this->whenLoaded('games')),
            'majors' => MajorResource::collection($this->whenLoaded('majors')),
        ];
    }
}
