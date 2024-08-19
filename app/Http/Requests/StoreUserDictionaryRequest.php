<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserDictionaryRequest extends BaseUserDictionaryRequest
{
    final public function rules(): array
    {
        $rules = parent::rules();

        $rules['word_id'][] =
            Rule::unique('user_dictionaries')->where(function ($query) {
                return $query->where('user_id', $this->user_id)
                    ->where('word_id', $this->word_id);
            });

        return $rules;
    }
}
