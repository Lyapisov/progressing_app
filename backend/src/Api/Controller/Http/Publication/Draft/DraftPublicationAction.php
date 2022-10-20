<?php

namespace App\Api\Controller\Http\Publication\Draft;

use App\Publications\Application\Publication\Draft\DraftPublicationCommand;
use App\Publications\Application\Publication\Draft\DraftPublicationHandler;
use App\Publications\Infrastructure\Repositories\AuthorRepository;
use App\Publications\Infrastructure\Repositories\PublicationRepository;
use App\UserAccess\Infrastructure\Security\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DraftPublicationAction
{
    public function __construct(
        private AuthService $authService,
        private DraftPublicationHandler $draftPublicationHandler,
        private AuthorRepository $authorRepository,
        private PublicationRepository $publicationRepository,
    ) {
    }

    /**
     * @Route(
     *     "/publications/{id}/draft",
     *     methods={"PATCH"}
     * )
     */
    public function __invoke(Request $request, string $id): JsonResponse
    {
        $userIdentity = $this->authService->getUserIdentity();
        $author = $this->authorRepository->getById($userIdentity->getId());
        $publication = $this->publicationRepository->getById($id);

        if ($author->getId() !== $publication->getAuthorId()) {
            throw new AccessDeniedHttpException("Доступ к публикации запрещен.");
        }

        $this->draftPublicationHandler->handle(
            new DraftPublicationCommand($id)
        );

        return new JsonResponse(null, Response::HTTP_OK);
    }
}
