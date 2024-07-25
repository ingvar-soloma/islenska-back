<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseLanguageRequest extends FormRequest
{
    final public function authorize(): bool
    {
        return true;
    }

    final public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:255'
        ];
    }
}
