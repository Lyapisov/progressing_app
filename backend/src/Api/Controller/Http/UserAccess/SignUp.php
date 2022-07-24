<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\UserAccess;

use App\SharedKernel\Application\Service\Typiser;
use App\SharedKernel\Domain\Exceptions\InvalidCommandException;
use App\UserAccess\Application\SignUp\SignUpCommand;
use App\UserAccess\Application\SignUp\SignUpHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class SignUp
{
    public function __construct(
        private SignUpHandler $signUpHandler,
        private Typiser $typiser
    ) {
    }

    /**
     * @Route(
     *     path="/sign-up",
     *     name="sign-up",
     *     methods={"POST"}
     * )
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidCommandException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $readModel = $this->signUpHandler->handle(
            new SignUpCommand(
                $this->typiser->toString($request->get('login')),
                $this->typiser->toString($request->get('email')),
                $this->typiser->toString($request->get('password')),
            )
        );

        $responseContent = [
            'user' =>
                [
                    'login' => $readModel->getLogin(),
                    'email' => $readModel->getEmail(),
                ]
        ];

        return new JsonResponse($responseContent, JsonResponse::HTTP_OK);
    }
}
