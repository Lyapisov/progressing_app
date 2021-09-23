<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\Profiles\Create;

use App\Profiles\Application\Fan\Create\Command;
use App\Profiles\Application\Fan\Create\Handler;
use App\SharedKernel\Application\Service\Typiser;
use App\SharedKernel\Domain\Auth\UserIdentity;
use App\SharedKernel\Infrastructure\EventSubscribers\Auth\AuthSecuritySubscriber;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateFanAction
{
    public function __construct(
        private Handler $createFanHandler,
        private Typiser $typiser,
    ) {
    }

    /**
     * @Route("/profile/create/fan")
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var UserIdentity $userIdentity */
        $userIdentity = $request->get(AuthSecuritySubscriber::USER_IDENTITY);

        $user = '';

        $readModel = $this->createFanHandler->handle(new Command(
                $userId = '',
                $login = '',
                $this->typiser->toString($request->get('firstName', '')),
                $this->typiser->toStringOrNull($request->get('lastName', '')),
                $this->typiser->toStringOrNull($request->get('fatherName', '')),
                new DateTimeImmutable($this->typiser->toString($request->get('birthday', ''))),
                $this->typiser->toString($request->get('address', '')),
                $this->typiser->toString($request->get('phone', '')),
            )
        );

        $responseContent = [
            'fanId' => $readModel->getId(),
        ];

        return new JsonResponse($responseContent, Response::HTTP_CREATED);
    }
}
