<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ReadWordRequest extends FormRequest
{
    final public function rules(): array
    {
        return [
            'language_from' => ['required', 'exists:languages,symbol'],
            'language_to' => ['required', 'exists:languages,symbol'],
            'text_entity_id' => ['sometimes', 'exists:text_entities,id'],
            'topic_id' => ['sometimes', 'exists:topics,id'],
        ];
    }

    final public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if ($this->filled('text_entity_id') && $this->filled('topic_id')) {
                $error = 'The text_entity_id and topic_id fields cannot be present together.';

                $validator->errors()->add('text_entity_id', $error);
                $validator->errors()->add('topic_id', $error);
            }
        });
    }
}
