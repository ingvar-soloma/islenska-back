<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReadTranslationRequest extends FormRequest
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
