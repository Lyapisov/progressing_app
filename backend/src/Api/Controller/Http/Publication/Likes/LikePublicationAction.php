<?php

namespace App\Api\Controller\Http\Publication\Likes;

use App\Publications\Application\Publication\Like\LikePublicationCommand;
use App\Publications\Application\Publication\Like\LikePublicationHandler;
use App\Publications\Infrastructure\Repositories\AuthorRepository;
use App\UserAccess\Infrastructure\Security\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikePublicationAction
{
    public function __construct(
        private AuthService $authService,
        private LikePublicationHandler $likePublicationHandler,
        private AuthorRepository $authorRepository,
    ) {
    }

    /**
     * @Route(
     *     "/publications/{id}/like",
     *     methods={"PATCH"}
     * )
     */
    public function __invoke(Request $request, string $id): JsonResponse
    {
        $userIdentity = $this->authService->getUserIdentity();
        $author = $this->authorRepository->getById($userIdentity->getId());

        $this->likePublicationHandler->handle(
            new LikePublicationCommand($id, $author->getId())
        );

        return new JsonResponse(null, Response::HTTP_OK);
    }
}
