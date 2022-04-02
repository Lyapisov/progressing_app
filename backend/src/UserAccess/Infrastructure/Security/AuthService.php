<?php

namespace App\UserAccess\Infrastructure\Security;

interface AuthService
{
    public function getUserIdentity(): UserIdentity;
}
