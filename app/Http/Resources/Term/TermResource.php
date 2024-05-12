<?php

namespace App\Http\Resources\Term;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TermResource extends JsonResource
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
            'study_set_id' => $this->study_set_id,
            'term' => $this->term,
            'definition' => $this->definition,
            'image_url' => $this->image_url,
            'status' => $this->study_results[0]->status ?? 0,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
