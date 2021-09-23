<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Validator;

use App\SharedKernel\Application\Service\Validator as ValidatorInterface;
use App\SharedKernel\Domain\Exceptions\InvalidCommandException;
use Symfony\Component\Validator\Validator\ValidatorInterface as SymfonyValidatorInterface;

final class Validator implements ValidatorInterface
{
    public function __construct(
        private SymfonyValidatorInterface $symfonyValidator
    ) {
    }

    /**
     * Позволяет гарантировать, что команда валидна.
     *
     * @throws InvalidCommandException
     * @param object $command
     */

    public function validation(object $command): void
    {
        $errorsMessages = $this->getValidationErrors($command);

        if ($errorsMessages) {
            throw new InvalidCommandException($errorsMessages);
        }
    }

    /**
     * Возвращает ошибки валидации команды.
     *
     * @param object $command
     * @return array<string>
     */
    protected function getValidationErrors(object $command): array
    {
        $errors = $this
            ->symfonyValidator
            ->validate($command);

        $errorsMessages = [];

        foreach ($errors as $error) {
            array_push($errorsMessages, $error->getMessage());
        }
        return $errorsMessages;
    }
}
