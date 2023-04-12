<?php

namespace App\Services\Authentication;

class AuthenticationService implements AuthenticationServiceContract
{
    public function loginAdvertiser(array $credentials)
    {
        if (!$token = auth('advertisers')->setTTl(6*60)->attempt($credentials)) {
            throw new \Exception('Not authorized', 401);
        }

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('advertisers')->factory()->getTTL(),
            'user' => auth('advertisers')->user(),
        ];
    }

    public function loginContractor(array $credentials)
    {
        if (!$token = auth('contractors')->setTTl(6*60)->attempt($credentials)) {
            throw new \Exception('Not authorized', 401);
        }

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('contractors')->factory()->getTTL(),
            'user' => auth('contractors')->user(),
        ];
    }
}
