<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Exceptions;

use Exception;

final class InvalidCommandException extends Exception
{
    /**
     * Ошибки валидации прикладной команды/запроса.
     *
     * @var array<string>
     */
    private array $errors = [];

    /**
     * @param array<string> $errors
     */
    public function __construct(array $errors)
    {
        array_map(function ($error) {
            $this->addError($error);
        }, $errors);

        parent::__construct('Ошибка валидации команды!');
    }

    /**
     * @return array<string>
     */
    public function getErrorsMessages(): array
    {
        return $this->errors;
    }

    /**
     * @param string $error
     */
    private function addError(string $error): void
    {
        array_push($this->errors, $error);
    }
}
