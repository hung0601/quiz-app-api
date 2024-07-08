<?php

namespace App\Http\Requests\StudySet;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'string',
            'description' => 'string',
            'image' => 'mimes:jpeg,png,jpg,gif|nullable',
            'term_lang' => 'string',
            'def_lang' => 'string',
            'access_type' => 'integer',
            'topic_ids' => 'array|nullable',
            'topic_ids.*' => 'integer|exists:topics,id',
        ];
    }
}
