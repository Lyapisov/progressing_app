<?php

declare(strict_types=1);

namespace App\UserAccess\Application\Get\ByCredentials;

use App\UserAccess\UseCase\ReadModel\UserRepository;
use App\UserAccess\UseCase\SignUp\PasswordOperator;

final class Handler
{
    public function __construct(
        private UserRepository $userRepository,
        private PasswordOperator $passwordOperator,
    ) {
    }

    public function handle(Query $query): ?ReadModel
    {
        $user = $this->userRepository->findByEmail($query->getEmail());

        if (is_null($user)) {
            return null;
        }

        if (!$this->passwordOperator->checkPassword($query->getPassword(), $user->getPassword())) {
            return null;
        }

        return new ReadModel($user->getId(), $user->getLogin(), $user->getEmail());
    }
}
