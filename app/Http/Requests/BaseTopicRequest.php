<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseTopicRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            // Additional validation rules
        ];
    }
}
