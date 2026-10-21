<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthService
{
    public function login(array $credentials): ?array
    {
        $guard = Auth::guard('api');

        $token = $guard->attempt($credentials);

        if (!$token) {
            return null;
        }

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl', 60) * 60,
            'user' => $guard->user(),
        ];
    }
    public function register(array $data): array
    {
        $user = new User();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->role = 'USER';

        $user->save();

        // Generate JWT directly after registration
        $guard = Auth::guard('api');

        $token = $guard->login($user);

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl', 60) * 60,
            'user' => $user,
        ];
    }
    public function me(): User
    {
        return Auth::guard('api')->user();
    }
}
