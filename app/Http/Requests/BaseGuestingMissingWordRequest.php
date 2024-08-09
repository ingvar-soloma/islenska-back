<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseGuestingMissingWordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text_entities_guesting_id' => 'required|integer',
            'word_id' => 'required|integer',
        ];
    }
}
