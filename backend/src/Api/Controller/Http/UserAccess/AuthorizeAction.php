<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\UserAccess;

use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\UserAccess\Application\Get\ByCredentials\Handler;
use App\UserAccess\Application\Get\ByCredentials\Query;
use App\UserAccess\Domain\OAuth\UserIdentity;
use League\OAuth2\Server\Exception\OAuthServerException;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

final class AuthorizeAction
{
    private Environment $twig;

    public function __construct(
        private AuthorizationServer $authorizationServer,
        private Handler $handler,
    ) {
        $loader = new FilesystemLoader(__DIR__ . '/../../../../../templates');
        $this->twig = new Environment($loader);
    }

    /**
     * @Route("/authorize", name="user-authorize", methods={"GET", "POST"})
     */
    public function __invoke(SymfonyRequest $request): SymfonyResponse
    {
        try {
            $psrRequest = $this->createPsrRequest($request);
            $authRequest = $this->authorizationServer->validateAuthorizationRequest($psrRequest);

            if ($psrRequest->getMethod() === 'POST') {
                $query = $this->getQueryByHandler($psrRequest);
                $user = $this->handler->handle($query);

                if ($user === null) {
                    $error = 'Неверный email или пароль.';

                    return new SymfonyResponse(
                            $this->twig->render('authorize.html.twig',
                            compact('query', 'error'),
                            )
                        );
                }

                $authRequest->setUser(new UserIdentity($user->getId()));
                $authRequest->setAuthorizationApproved(true);

                $psrResponse = $this->authorizationServer
                    ->completeAuthorizationRequest($authRequest, new PsrResponse());

                return $this->createSymfonyResponse($psrResponse);
            }

            return new SymfonyResponse(
                $this->twig->render('authorize.html.twig'),
                SymfonyResponse::HTTP_OK
            );

        } catch (OAuthServerException $exception) {
            $errorResponse = new PsrResponse(
                500,
                ['Content-Type' => 'text/html'],
                ''
            );

            return $this->createSymfonyResponse($exception->generateHttpResponse($errorResponse));
        }
    }

    private function createPsrRequest(SymfonyRequest $request): ServerRequestInterface
    {
        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
        return $psrHttpFactory->createRequest($request);
    }

    private function createSymfonyResponse(ResponseInterface $psrResponse): SymfonyResponse
    {
        $httpFundFactory = new HttpFoundationFactory();
        return $httpFundFactory->createResponse($psrResponse);
    }

    private function getQueryByHandler(ServerRequestInterface $psrRequest): Query
    {
        $body = $psrRequest->getParsedBody();

        $query = new Query(
            $body['email'] ?? '',
            $body['password'] ?? ''
        );

        return $query;
    }
}
