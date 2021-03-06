<?php

declare(strict_types=1);

namespace App\Util\PasswordOperator;

use Exception;

final class HashPasswordOperator implements PasswordOperator
{
    /**
     * @param string $password
     * @return string
     * @throws Exception
     */
    public function encryptPassword(string $password): string
    {
        $encryptPassword = password_hash($password, PASSWORD_BCRYPT);

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
