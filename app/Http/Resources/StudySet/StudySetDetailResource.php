<?php

namespace App\Http\Resources\StudySet;

use App\Http\Resources\Term\TermResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudySetDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'term_lang' => $this->term_lang,
            'def_lang' => $this->def_lang,
            'course_id' => $this->course_id,
            'owner_id' => $this->owner_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'vote_count' => $this->vote_count,
            'votes_avg_star' => $this->votes_avg_star,
            'permission' => $this->permission,
            'owner' => $this->owner,
            'topics' => $this->topics,
            'terms' => TermResource::collection($this->terms),
            'exams' => $this->exams
        ];
    }
}
