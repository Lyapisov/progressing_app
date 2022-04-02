<?php

namespace App\UserAccess\Infrastructure\Security;


use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\UsageTrackingTokenStorage;

final class SymfonyTokenStorageAuthService implements AuthService
{
    public function __construct(
        private UsageTrackingTokenStorage $tokenStorage
    ) {
    }

    public function getUserIdentity(): UserIdentity
    {
        if (null === ($token = $this->tokenStorage->getToken())) {
            throw new UnauthorizedHttpException(
                '',
                'Неверный токен авторизации!'
            );
        }
        if (!$token->getUser() instanceof UserIdentity) {
            throw new UnauthorizedHttpException(
                '',
                'Неверный токен авторизации!'
            );
        }

        return $token->getUser();
    }
}
