<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseReadingProgressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text_entity_id' => 'required|integer|exists:text_entities,id',
            'read' => 'boolean'
        ];
    }
}
