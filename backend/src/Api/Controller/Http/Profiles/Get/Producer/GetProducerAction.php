<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\Profiles\Get\Producer;

use App\Profiles\Application\Producer\Get\ById\GetProducerByIdHandler;
use App\Profiles\Application\Producer\Get\ById\GetProducerByIdQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class GetProducerAction
{
    public function __construct(
        private GetProducerByIdHandler $getProducerByIdHandler
    ) {
    }

    /**
     * @Route(
     *     path="/profiles/producers/{id}",
     *     name="get-producer-profile",
     *     methods={"GET"}
     * )
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function __invoke(string $id, Request $request): JsonResponse
    {
        $readModel = $this->getProducerByIdHandler->handle(new GetProducerByIdQuery($id));

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
