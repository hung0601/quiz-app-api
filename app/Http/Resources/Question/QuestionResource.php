<?php

namespace App\Http\Resources\Question;

use App\Models\TestQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function json_decode;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->question_type == TestQuestion::MULTIPLE_CHOICE_QUESTION){
            $this->question->answers = json_decode($this->question->answers);
        }
        if ($this->question_type == TestQuestion::TRUE_FALSE_QUESTION){
            $this->question->correct_answer = (bool) $this->question->correct_answer;
        }
        return [
            'id' => $this->id,
            'test_id' => $this->test_id,
            'term_referent_id' => $this->term_referent_id,
            'has_audio' => (bool)$this->has_audio,
            'audio_text' => $this->audio_text,
            'audio_lang' => $this->audio_lang,
            'question_type' => $this->question_type,
            'point' => $this->point,
            'question' => $this->question,
        ];
    }
}
