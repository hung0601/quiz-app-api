<?php

namespace App\Http\Requests\StudySet;

use Illuminate\Foundation\Http\FormRequest;

class StoreSetRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif',
            'term_lang' => 'string|nullable',
            'def_lang' => 'string|nullable',
            'access_type' => 'integer',
            'topic_ids' => 'array',
            'topic_ids.*' => 'integer|exists:topics,id',
        ];
    }
}
