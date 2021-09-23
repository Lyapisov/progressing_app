<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\Profiles\Get;

use App\Profiles\Application\GetById\Handler;
use App\Profiles\Application\GetById\Query;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ById
{
    public function __construct(
        private Handler $fanHandler
    ) {
    }

    /**
     * @Route(
     *     path="/profile/{id}",
     *     name="get-profile",
     *     methods={"GET"}
     * )
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function __invoke(string $id, Request $request): JsonResponse
    {
        $readModel = $this->fanHandler->handle(new Query($id));

        $favoriteMusicians = [];
        foreach ($readModel->getFavoriteMusicians() as $favoriteMusician) {
            $favoriteMusicians[] = [ 'musicianId' => $favoriteMusician->getId() ];
        }

        $responseContent = [
            'fanId' => $readModel->getFanId(),
            'name' => $readModel->getName(),
            'favoriteMusicians' => $favoriteMusicians
        ];

        return new JsonResponse($responseContent, JsonResponse::HTTP_OK);
    }
}
