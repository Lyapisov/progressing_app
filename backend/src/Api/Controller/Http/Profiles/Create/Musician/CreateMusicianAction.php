<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\Profiles\Create\Musician;

use App\Profiles\Application\Musician\Create\Command;
use App\Profiles\Application\Musician\Create\Handler;
use App\SharedKernel\Application\Service\Typiser;
use App\UserAccess\Infrastructure\Security\AuthService;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateMusicianAction
{
    public function __construct(
        private Handler $createMusicianHandler,
        private Typiser $typiser,
        private AuthService $authService,
    ) {
    }

    /**
     * @Route(
     *     "/profiles/musicians",
     *     methods={"POST"}
     * )
     */
    public function __invoke(Request $request): JsonResponse
    {
        $userIdentity = $this->authService->getUserIdentity();

        $readModel = $this->createMusicianHandler->handle(new Command(
            $userIdentity->getId(),
            $this->typiser->toString($request->get('firstName', '')),
            $this->typiser->toStringOrNull($request->get('lastName', '')),
            $this->typiser->toStringOrNull($request->get('fatherName', '')),
            new DateTimeImmutable($this->typiser->toString($request->get('birthday', ''))),
            $this->typiser->toStringOrNull($request->get('address', '')),
            $this->typiser->toStringOrNull($request->get('phone', '')),
        ));

        $responseContent = [
            'id' => $readModel->getId(),
        ];

        return new JsonResponse($responseContent, Response::HTTP_CREATED);
    }
}
