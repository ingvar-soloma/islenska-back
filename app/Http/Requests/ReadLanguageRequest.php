<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReadLanguageRequest extends FormRequest
{
    final public function rules(): array
    {
        return [
            'symbol' => 'sometimes|string|exists:languages,symbol',
        ];
    }
}

