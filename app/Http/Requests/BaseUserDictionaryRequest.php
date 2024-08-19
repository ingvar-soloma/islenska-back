<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseUserDictionaryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'word_id' => [
                'required',
                'integer',
                'exists:words,id',
            ],
            'level_of_knowing' => [
                'required',
                'integer',
                'min:0',
                'max:10',
            ],
            'stability' => [
                'required',
                'integer',
                'min:0',
                'max:10',
            ],
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
        ];
    }

    final protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }
}
