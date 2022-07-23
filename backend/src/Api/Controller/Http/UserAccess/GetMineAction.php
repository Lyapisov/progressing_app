<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\UserAccess;

use App\Profiles\Application\FindByUserId\Handler;
use App\Profiles\Application\FindByUserId\Query;
use App\UserAccess\Infrastructure\Security\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetMineAction
{
    public function __construct(
        private AuthService $authService,
        private Handler $findProfileHandler,
    ) {
    }

    /**
     * @Route("/users/mine", name="get-mine", methods={"GET"})
     */
    public function __invoke(Request $request): JsonResponse
    {
        $userIdentity = $this->authService->getUserIdentity();

        $foundReadModel = $this->findProfileHandler->handle(
            new Query($userIdentity->getId())
        );

        $responseContent = [
            'id' => $userIdentity->getId(),
            'profileCreated' => $foundReadModel->isFound(),
            'isFan' => $foundReadModel->isFan(),
            'isMusician' => $foundReadModel->isMusician(),
            'isProducer' => $foundReadModel->isProducer(),
        ];

        return new JsonResponse($responseContent, Response::HTTP_OK);
    }
}
