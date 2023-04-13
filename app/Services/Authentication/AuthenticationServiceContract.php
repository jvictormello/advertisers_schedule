<?php

namespace App\Services\Authentication;

interface AuthenticationServiceContract
{
    public function loginAdvertiser(array $credentials);
    public function loginContractor(array $credentials);
}
