<?php

namespace App\Http\Traits;

use App\Models\User;
use Illuminate\Http\JsonResponse;

trait AuthResponseFormatter
{
    /**
     * Format authentication response with user data, token, permissions and roles
     *
     * @param User $user
     * @param string $token
     * @param string|null $message
     * @param int $statusCode
     * @return JsonResponse
     */
    final protected function formatAuthResponse(
        User $user,
        string $token,
        ?string $message = null,
        int $statusCode = 200
    ): JsonResponse {
        // Ensure permissions and roles are loaded
        $user->load('roles', 'permissions');

        $response = [
            'token' => $token,
            'user' => $user,
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'roles' => $user->getRoleNames(),
        ];

        if ($message) {
            $response['message'] = $message;
        }

        return response()->json($response, $statusCode);
    }
}
