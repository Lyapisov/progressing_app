<?php

declare(strict_types=1);

namespace App\UserAccess\Test\Helper;

use App\UserAccess\UseCase\SignUp\PasswordOperator;
use Exception;

final class PasswordOperatorStub implements PasswordOperator
{
    /**
     * @param string $password
     * @return string
     * @throws Exception
     */
    public function encryptPassword(string $password): string
    {
        $encryptPassword = password_hash($password, PASSWORD_ARGON2I, ['memory_cost' => 16]);

        if (!$encryptPassword) {
            throw new Exception('Возникла ошибка при хэшировании пароля.');
        }

        return $encryptPassword;
    }

    /**
     * @param string $enteredPassword
     * @param string $currentEncryptPassword
     * @return bool
     */
    public function checkPassword(string $enteredPassword, string $currentEncryptPassword): bool
    {
        return password_verify($enteredPassword, $currentEncryptPassword);
    }
}
