<?php

namespace App\Http\Requests;

class UpdateUserDictionaryRequest extends BaseUserDictionaryRequest
{

    final public function rules(): array
    {
        $rules = parent::rules();

        $rules['level_of_knowing'][0] = 'sometimes';
        $rules['stability'][0] = 'sometimes';
        unset($rules['word_id']);

        return $rules;
    }
}
