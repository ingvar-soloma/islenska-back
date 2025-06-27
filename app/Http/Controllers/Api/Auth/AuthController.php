<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Traits\AuthResponseFormatter;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use AuthResponseFormatter;

    /**
     * Register a new user
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    final public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        $token = $user->createToken('authToken')->plainTextToken;

        return $this->formatAuthResponse($user, $token, null, 201);
    }

    /**
     * Login a user
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    final public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return $this->formatAuthResponse($user, $token);
    }

    /**
     * Logout the user by revoking all tokens
     *
     * @return JsonResponse
     */
    final public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }

    final public function showLoginForm(): Factory|\Illuminate\Contracts\View\View|Application|\Illuminate\View\View
    {
        return view('auth.login');
    }
}
