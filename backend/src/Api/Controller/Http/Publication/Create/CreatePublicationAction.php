<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\Publication\Create;

use App\Publications\Application\Publication\Create\CreatePublicationCommand;
use App\Publications\Application\Publication\Create\CreatePublicationHandler;
use App\Publications\Infrastructure\Repositories\AuthorRepository;
use App\UserAccess\Infrastructure\Security\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreatePublicationAction
{
    public function __construct(
        private AuthService $authService,
        private CreatePublicationHandler $createPublicationHandler,
        private AuthorRepository $authorRepository,
    ) {
    }

    /**
     * @Route(
     *     "/publications",
     *     methods={"POST"}
     * )
     */
    public function __invoke(CreateRequest $request): JsonResponse
    {
        $userIdentity = $this->authService->getUserIdentity();
        $author = $this->authorRepository->getById($userIdentity->getId());

        $readModel = $this->createPublicationHandler->handle(
            new CreatePublicationCommand(
                $author->getId(),
                $request->getTitle(),
                $request->getText(),
                $request->getImageId(),
            )
        );

        $responseContent = [
            'id' => $readModel->getId(),
        ];

        return new JsonResponse($responseContent, Response::HTTP_CREATED);
    }
}
