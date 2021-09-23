<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\UserAccess;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\Routing\Annotation\Route;

final class AccessTokenAction
{
    public function __construct(
        private AuthorizationServer $authorizationServer,
    ) {
    }

    /**
     * @Route("/access-token", name="access-token", methods={"POST"})
     */
    public function __invoke(SymfonyRequest $symfonyRequest): SymfonyResponse
    {
        try {
            $psrRequest = $this->createPsrRequest($symfonyRequest);
            $psrResponse = $this->authorizationServer->respondToAccessTokenRequest($psrRequest, new PsrResponse());

            return $this->createSymfonyResponse($psrResponse);

        } catch (OAuthServerException $exception) {
            $errorResponse = new PsrResponse(
                500,
                ['Content-Type' => 'text/html'],
                ''
            );

            return $this->createSymfonyResponse(
                $exception->generateHttpResponse($errorResponse)
            );
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
}
