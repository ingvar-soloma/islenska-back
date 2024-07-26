<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseWordRequest extends FormRequest
{
    final public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
