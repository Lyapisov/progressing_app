<?php

namespace App\Api\Controller\Http\Publication\GetById;

use App\Publications\Application\Publication\Get\ById\GetPublicationHandler;
use App\Publications\Application\Publication\Get\ById\GetPublicationQuery;
use App\Publications\Infrastructure\Repositories\AuthorRepository;
use App\UserAccess\Infrastructure\Security\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetPublicationAction
{
    public function __construct(
        private GetPublicationHandler $getPublicationHandler,
        private AuthService $authService,
        private AuthorRepository $authorRepository,
    ) {
    }

    /**
     * @Route(
     *     "/publications/{id}",
     *     methods={"GET"}
     * )
     */
    public function __invoke(Request $request, string $id): JsonResponse
    {
        $userIdentity = $this->authService->getUserIdentity();
        $author = $this->authorRepository->getById($userIdentity->getId());

        $readModel = $this->getPublicationHandler->handle(new GetPublicationQuery($id));

        $responseContent = [
            'id' => $readModel->getId(),
            'authorId' => $readModel->getAuthorId(),
            'content' => [
                'title' => $readModel->getContentTitle(),
                'text' => $readModel->getContentText(),
                'imageId' => $readModel->getContentImageId(),
            ],
            'status' => $readModel->getStatus(),
            'countLikes' => $readModel->getLikesCount(),
            'createdAt' => $readModel->getCreatedAt()->getTimestamp(),
        ];

        return new JsonResponse($responseContent, Response::HTTP_OK);
    }
}