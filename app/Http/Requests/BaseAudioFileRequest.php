<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseAudioFileRequest extends FormRequest
{
    final public function rules(): array
    {
        return [
            'file_name' => 'required|string',
        ];
    }
}
