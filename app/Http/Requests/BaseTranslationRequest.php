<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseTranslationRequest extends FormRequest
{
    final public function rules(): array
    {
        return [
            'word_from_id' => 'required|integer|exists:words,id',
            'word_to_id' => 'required|integer|exists:words,id',
        ];
    }
}
