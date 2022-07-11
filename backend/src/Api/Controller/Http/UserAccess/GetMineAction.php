<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\UserAccess;

use App\UserAccess\Infrastructure\Security\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetMineAction
{
    public function __construct(
        private AuthService $authService
    ) {
    }

    /**
     * @Route("/users/get/mind", name="get-mind-user", methods={"GET"})
     */
    public function __invoke(Request $request): JsonResponse
    {

        $userIdentity = $this->authService->getUserIdentity();

        return new JsonResponse([
                'id' => $userIdentity->getId(),
            ],
            Response::HTTP_OK
        );
    }
}
