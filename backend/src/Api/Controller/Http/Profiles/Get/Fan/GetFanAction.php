<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\Profiles\Get\Fan;

use App\Profiles\Application\Fan\Get\ById\GetFanByIdHandler;
use App\Profiles\Application\Fan\Get\ById\GetFanByIdQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class GetFanAction
{
    public function __construct(
        private GetFanByIdHandler $fanHandler
    ) {
    }

    /**
     * @Route(
     *     path="/profiles/fans/{id}",
     *     name="get-fan-profile",
     *     methods={"GET"}
     * )
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function __invoke(string $id, Request $request): JsonResponse
    {
        $readModel = $this->fanHandler->handle(new GetFanByIdQuery($id));

        $responseContent = [
            'id' => $readModel->getId(),
            'personalData' => [
                'name' => [
                    'first' => $readModel->getFirstName(),
                    'last' => $readModel->getLastName(),
                    'father' => $readModel->getFatherName(),
                ],
                'phone' => [
                    'number' => $readModel->getPhoneNumber(),
                ],
                'address' => $readModel->getAddress(),
                'birthday' => $readModel->getBirthday()->getTimestamp()
            ]
        ];

        return new JsonResponse($responseContent, JsonResponse::HTTP_OK);
    }
}
