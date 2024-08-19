<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class StoreWordRequest extends BaseWordRequest
{
    final public function rules(): array {
        $rules = parent::rules();

        $rules['name'] = Rule::unique('words')->where(function ($query) {
            return $query->where('name', $this->name)
                ->where('language_id', $this->language_id);
        });

        return array_merge($rules, [
            'translation_id' => 'sometimes|exists:words,id',
        ]);
    }
}
