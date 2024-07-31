<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserDictionaryRequest extends BaseUserDictionaryRequest
{
    final protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }

    final public function rules(): array
    {
        $rules = parent::rules();

        return array_merge($rules, [
            'user_id' => 'required|integer|exists:users,id',
        ]);
    }
}
