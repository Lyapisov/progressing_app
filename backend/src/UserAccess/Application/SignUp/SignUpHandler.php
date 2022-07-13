<?php

declare(strict_types=1);

namespace App\UserAccess\Application\SignUp;

use App\SharedKernel\Application\Service\EventDispatcher;
use App\SharedKernel\Application\Service\Validator;
use App\SharedKernel\Domain\Exceptions\InvalidCommandException;
use App\UserAccess\Domain\Role;
use App\UserAccess\Domain\User;
use App\UserAccess\Application\SignUp\UserReadModel;
use App\UserAccess\Domain\UserRepository;
use App\Util\PasswordOperator\PasswordOperator;
use DateTimeImmutable;

final class SignUpHandler
{
    private UserRepository $userRepository;

    private PasswordOperator $passwordOperator;

    private EventDispatcher $dispatcher;

    private Validator $validator;

    public function __construct(
        UserRepository $userRepository,
        PasswordOperator $passwordOperator,
        EventDispatcher $dispatcher,
        Validator $validator
    ) {
        $this->userRepository = $userRepository;
        $this->passwordOperator = $passwordOperator;
        $this->dispatcher = $dispatcher;
        $this->validator = $validator;
    }

    /**
     * @throws InvalidCommandException
     */
    public function handle(SignUpCommand $command): UserReadModel
    {
        $this->validator->validation($command);

        $login = $command->getLogin();
        $email = $command->getEmail();

        if ($this->userRepository->existsByLogin($login)) {
            throw new \DomainException('Пользователь с таким логином уже существует.');
        }

        if ($this->userRepository->existsByEmail($email)) {
            throw new \DomainException('Пользователь с такой почтой уже существует.');
        }

        $newId = $this->userRepository->generateNewId();

        $user = new User(
            $newId,
            $login,
            $email,
            $command->getPassword(),
            new DateTimeImmutable(),
            $this->passwordOperator,
        );

        $this->userRepository->save($user);
        $this->dispatcher->dispatch($user->dispatchEventMessages());

        return new UserReadModel(
            $user->getLogin(),
            $user->getEmail(),
        );
    }
}
