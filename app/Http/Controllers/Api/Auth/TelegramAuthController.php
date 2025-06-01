<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\TelegramAuthRequest;
use App\Http\Services\TelegramAuthService;
use Illuminate\Http\JsonResponse;

class TelegramAuthController extends Controller
{

    public function __construct(private TelegramAuthService $telegramAuthService)
    {
    }

    final public function auth(TelegramAuthRequest $request): JsonResponse
    {
        $telegramUser = $request->validated()['telegram_user'];

        $this->telegramAuthService->verifyTelegramData($telegramUser);

        $user = $this->telegramAuthService->findOrCreateUser($telegramUser);

        return response()->json([
            'message' => 'Authenticated successfully',
            'user' => $user,
            'token' => $user->createToken('telegram_auth')->plainTextToken,
        ]);
    }
}
