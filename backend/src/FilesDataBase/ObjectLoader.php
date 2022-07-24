<?php

declare(strict_types=1);

namespace App\FilesDataBase;

use App\UserAccess\Domain\User;
use DateTimeImmutable;

class ObjectLoader
{
    private const USER_CLASS = 'User';

    /**
     * @param string $className
     * @param array<mixed> $data
     * @return User|null
     */
    protected function loadObject(string $className, array $data): ?User
    {
        $object = null;

        if ($className === self::USER_CLASS) {
            $object = $this->loadUser($data);
        }

        return $object;
    }

    /**
     * @param array<mixed> $data
     * @return User
     */
    private function loadUser(array $data): User
    {
        $user = new User(
            $data[0],
            $data[1],
            $data[2],
            $data[3],
            new DateTimeImmutable($data[4]),
            $data[5]
        );

        return $user;
    }
}
