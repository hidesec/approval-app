<?php

namespace App\Repositories\Auth;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthRepositoryInterface
{
    protected JWTAuth $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function login(array $credentials): array
    {
        try {
            if (!$token = $this->jwt->attempt($credentials)) {
                return ['error' => 'Unauthorized'];
            }

            $user = Auth::user();
            if ($user instanceof \App\Models\User) {
                return ['token' => $token, 'user' => $user];
            }

            return ['error' => 'User not found'];
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ['error' => 'Could not create token'];
        }
    }
}
