<?php

namespace App\Http\Requests;

class StoreWordRequest extends BaseWordRequest
{
    final public function rules(): array {
        $rules = parent::rules();

        return array_merge($rules, [
            'translation_id' => 'sometimes|exists:words,id',
        ]);
    }
}
