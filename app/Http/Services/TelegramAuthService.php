<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class TelegramAuthService
{
    final public function verifyTelegramData(array $data): void
    {
        $botToken = config('services.telegram.bot_token');
        $secretKey = hash('sha256', $botToken, true);

        $checkHash = $data['hash'];
        $authDate = $data['auth_date'] ?? null;
        unset($data['hash']);

        // Build data-check-string
        ksort($data);
        $dataCheckString = implode("\n", array_map(fn($key, $value) => "$key=$value", array_keys($data), $data));

        // Validate hash
        $hash = hash_hmac('sha256', $dataCheckString, $secretKey);

        if (!hash_equals($hash, $checkHash)) {
            throw ValidationException::withMessages(['hash' => 'Invalid Telegram data.']);
        }

        // Validate auth_date
        if (time() - $authDate > 86400) {
            throw ValidationException::withMessages(['auth_date' => 'Telegram data is outdated.']);
        }
    }

    // todo: extract to UserRepository
    final public function findOrCreateUser(array $data): User
    {
        return User::firstOrCreate(
            ['telegram_id' => $data['id']],
            [
                'name' => $data['first_name'],
                'username' => $data['username'] ?? null,
                'photo_url' => $data['photo_url'] ?? null,
                'password' => Hash::make(uniqid()),
            ]
        );
    }
}
