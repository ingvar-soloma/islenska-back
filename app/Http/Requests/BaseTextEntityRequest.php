<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseTextEntityRequest extends FormRequest
{
    final public function rules(): array
    {
        return [
            'text' => 'required|string',
            'level_id' => 'required|integer|exists:levels,id',
            'topic_id' => 'required|integer|exists:topics,id',
            'audio_file_id' => 'required|integer|exists:audio_files,id',
        ];
    }
}
