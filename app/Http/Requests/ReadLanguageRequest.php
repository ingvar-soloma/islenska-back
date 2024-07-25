<?php

namespace App\Http\Requests;

class ReadLanguageRequest
{
    final public function authorize(): bool
    {
        return true;
    }

    final public function rules(): array
    {
        return [
            //
        ];
    }
}

