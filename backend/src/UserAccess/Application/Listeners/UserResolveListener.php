<?php

declare(strict_types=1);

namespace App\UserAccess\Application\Listeners;

use App\UserAccess\Infrastructure\Security\UserIdentity;
use App\Util\PasswordOperator\PasswordOperator;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Trikoder\Bundle\OAuth2Bundle\Event\UserResolveEvent;

final class UserResolveListener
{
    public function __construct(
        private UserProviderInterface $userProvider,
        private PasswordOperator $passwordEncryptor,
    ) {
    }

    public function onUserResolve(UserResolveEvent $event): void
    {
        /** @var UserIdentity|null $user */
        $user = $this->userProvider->loadUserByUsername($event->getUsername());

        if (is_null($user)) {
            return;
        }

        if (!$user->getPassword()) {
            return;
        }

        if (!$this->passwordEncryptor->checkPassword($event->getPassword(), $user->getPassword())) {
            return;
        }

        $event->setUser($user);
    }
}
