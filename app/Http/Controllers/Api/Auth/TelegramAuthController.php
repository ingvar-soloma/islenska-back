<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\TelegramAuthRequest;
use App\Http\Services\TelegramAuthService;
use App\Http\Traits\AuthResponseFormatter;
use Illuminate\Http\JsonResponse;

class TelegramAuthController extends Controller
{
    use AuthResponseFormatter;

    /**
     * @param TelegramAuthService $telegramAuthService
     */
    public function __construct(private TelegramAuthService $telegramAuthService)
    {
    }

    /**
     * Authenticate user via Telegram
     *
     * @param TelegramAuthRequest $request
     * @return JsonResponse
     */
    final public function auth(TelegramAuthRequest $request): JsonResponse
    {
        $telegramUser = $request->validated()['telegram_user'];

        $this->telegramAuthService->verifyTelegramData($telegramUser);

        $user = $this->telegramAuthService->findOrCreateUser($telegramUser);
        $token = $user->createToken('telegram_auth')->plainTextToken;

        return $this->formatAuthResponse($user, $token, 'Authenticated successfully');
    }
}
