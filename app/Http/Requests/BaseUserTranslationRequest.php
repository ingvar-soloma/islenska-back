<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Base request for UserTranslation model
 * @property $user_id
 * @property $translation_id
 */
class BaseUserTranslationRequest extends FormRequest
{
    final public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'translation_id' => ['required', 'integer', 'exists:translations,id'],
        ];
    }
}
