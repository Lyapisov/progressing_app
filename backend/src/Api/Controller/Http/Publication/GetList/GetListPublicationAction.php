<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\Publication\GetList;

use App\Publications\Application\Publication\Get\AllByConditions\GetPublicationsByConditionsHandler;
use App\Publications\Application\Publication\Get\AllByConditions\Query\Filters;
use App\Publications\Application\Publication\Get\AllByConditions\Query\GetPublicationsByConditionsQuery;
use App\Publications\Application\Publication\Get\AllByConditions\Query\Sorting;
use App\Publications\Application\Publication\Get\AllByConditions\ReadModel;
use App\Publications\Infrastructure\Repositories\AuthorRepository;
use App\UserAccess\Infrastructure\Security\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetListPublicationAction
{
    public function __construct(
        private AuthService $authService,
        private GetPublicationsByConditionsHandler $getPublicationHandler,
        private AuthorRepository $authorRepository,
    ) {
    }

    /**
     * @Route(
     *     "/publications",
     *     methods={"GET"}
     * )
     */
    public function __invoke(GetListRequest $request): JsonResponse
    {
        $userIdentity = $this->authService->getUserIdentity();
        $author = $this->authorRepository->getById($userIdentity->getId());

        $readModels = $this->getPublicationHandler->handle(
            new GetPublicationsByConditionsQuery(
                new Filters(
                    $request->getAuthorsFilter(),
                    $request->getStatusesFilter(),
                ),
                new Sorting(
                    $request->getCreatedAtSorting(),
                )
            )
        );

        $responseContent = array_map(
            fn(ReadModel $readModel) =>
            [
                'id' => $readModel->getId(),
                'title' => $readModel->getTitle(),
                'status' => $readModel->getStatus(),
                'createdAt' => $readModel->getCreatedAt()->getTimestamp(),
            ],
            $readModels
        );

        return new JsonResponse($responseContent, Response::HTTP_OK);
    }
}
