<?php

declare(strict_types=1);

namespace App\UserAccess\Infrastructure\Security;

use App\UserAccess\Domain\User;
use App\UserAccess\Domain\UserRepository;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class OAuthUserProvider implements UserProviderInterface
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    public function loadUserByUsername(string $login)
    {
        $user = $this->loadUserByLogin($login);

        return new UserIdentity(
            $user->getId(),
            $user->getLogin(),
            $user->getPassword(),
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!($user instanceof UserIdentity)) {
            throw new UnsupportedUserException(
                'Невалидный класс пользователя ' . \get_class($user)
            );
        }
        $user = $this->loadUserByLogin($user->getId());

        return new UserIdentity(
            $user->getId(),
            $user->getLogin(),
            $user->getPassword(),
        );
    }

    /**
     * @param string $class
     */
    public function supportsClass($class): bool
    {
        return UserIdentity::class === $class;
    }

    private function loadUserByLogin(string $login): User
    {
        $user = $this->userRepository->findByLogin($login);
        if (is_null($user)) {
            throw new AuthenticationException('Неверный логин или пароль!');
        }

        return $user;
    }
}
