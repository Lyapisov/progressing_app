<?php


namespace App\SharedKernel\Application\Service;


use App\SharedKernel\Domain\Exceptions\InvalidCommandException;

interface Validator
{
    /**
     * Позволяет гарантировать, что команда валидна.
     *
     * @throws InvalidCommandException
     * @param object $command
     */
    public function validation(object $command): void;
}
