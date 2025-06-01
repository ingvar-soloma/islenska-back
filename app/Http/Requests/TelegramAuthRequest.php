<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TelegramAuthRequest extends FormRequest
{
    final public function rules(): array
    {
        return [
            'telegram_user.id' => 'required|integer',
            'telegram_user.first_name' => 'required|string',
            'telegram_user.last_name' => 'nullable|string',
            'telegram_user.username' => 'nullable|string',
            'telegram_user.photo_url' => 'nullable|url',
            'telegram_user.auth_date' => 'required|integer',
            'telegram_user.hash' => 'required|string',
        ];
    }
}
