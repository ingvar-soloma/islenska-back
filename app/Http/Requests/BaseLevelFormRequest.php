<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseLevelFormRequest extends FormRequest
{
    final public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }
}
