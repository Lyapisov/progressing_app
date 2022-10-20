<?php

declare(strict_types=1);

namespace App\Util\HttpRequest;

use Exception;

/**
 * Исключение, выбрасываемое в случае, если http запрос невалиден.
 */
final class RequestValidationException extends Exception
{
    /**
     * Ошибки валидации http запроса.
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

        parent::__construct('Ошибка валидации запроса!');
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
