<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login(
            $request->validated()
        );

        if (!$result) {
            return response()->json([
                'message' => 'Invalid email or password.'
            ], 401);
        }

        return response()->json([
            'message' => 'Login successful.',
            'data' => $result,
        ], 200);
    }
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register(
            $request->validated()
        );

        return response()->json([
            'message' => 'Registration successful.',
            'data' => [
                'access_token' => $result['access_token'],
                'token_type' => $result['token_type'],
                'expires_in' => $result['expires_in'],
                'user' => [
                    'id' => $result['user']->id,
                    'name' => $result['user']->name,
                    'email' => $result['user']->email,
                    'role' => $result['user']->role,
                ],
            ],
        ], 201);
    }
    public function me(): JsonResponse
    {
        $user = $this->authService->me();

        return response()->json([
            'message' => 'Authenticated user retrieved successfully.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ], 200);
    }
}
