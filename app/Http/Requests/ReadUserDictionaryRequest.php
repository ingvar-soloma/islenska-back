<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReadUserDictionaryRequest extends FormRequest
{
    final protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }


    final public function rules(): array
    {
        return [
            'user_id' => 'integer',
            'language_from' => 'required|exists:languages,symbol',
        ];
    }
}
