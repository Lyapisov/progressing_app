<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\UserAccess;

use App\SharedKernel\Domain\Auth\UserIdentity;
use App\SharedKernel\Infrastructure\EventSubscribers\Auth\AuthSecuritySubscriber;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetMineAction
{
    /**
     * @Route("/users/get/mind", name="get-mind-user", methods={"GET"})
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var UserIdentity $userIdentity */
        $userIdentity = $request->get(AuthSecuritySubscriber::USER_IDENTITY);

        return new JsonResponse([
                'id' => $userIdentity->getId()
            ],
            Response::HTTP_OK
        );
    }
}
