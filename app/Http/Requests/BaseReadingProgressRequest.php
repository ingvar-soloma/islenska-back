<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseReadingProgressRequest extends FormRequest
{
    final protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }
    public function rules(): array
    {
        return [
            'text_entity_id' => 'required|integer|exists:text_entities,id',
            'user_id' => 'required|integer|exists:users,id',
            'read' => 'boolean',
        ];
    }
}
