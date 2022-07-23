<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\Profiles\Get;

use App\Profiles\Application\FindByUserId\Handler;
use App\Profiles\Application\FindByUserId\Query;
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
     *     path="/profiles/{id}",
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
        //TODO: Реализовать
//        $responseContent = [
//            'fanId' => $readModel->getFanId(),
//        ];

        return new JsonResponse('', JsonResponse::HTTP_OK);
    }
}
