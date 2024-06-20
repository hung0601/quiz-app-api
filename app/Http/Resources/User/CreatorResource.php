<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreatorResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'image_url' => $this->image_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'courses_count' => $this->courses_count ?? 0,
            'study_sets_count' => $this->study_sets_count ?? 0,
            'followers_count' => $this->followers_count ?? 0,
            'is_following' => $this->is_following > 0 ? true : false,
        ];
    }
}
