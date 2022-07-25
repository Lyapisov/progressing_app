<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\Profiles\Get\Musician;

use App\Profiles\Application\Musician\Get\ById\GetMusicianByIdHandler;
use App\Profiles\Application\Musician\Get\ById\GetMusicianByIdQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class GetMusicianAction
{
    public function __construct(
        private GetMusicianByIdHandler $getMusicianByIdHandler
    ) {
    }

    /**
     * @Route(
     *     path="/profiles/musicians/{id}",
     *     name="get-musician-profile",
     *     methods={"GET"}
     * )
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function __invoke(string $id, Request $request): JsonResponse
    {
        $readModel = $this->getMusicianByIdHandler->handle(new GetMusicianByIdQuery($id));

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
