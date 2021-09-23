<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\EventSubscribers\Auth;

use App\SharedKernel\Domain\Auth\UserIdentity;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResourceServer;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

final class AuthSecuritySubscriber implements EventSubscriberInterface
{
    public const USER_IDENTITY = 'user_identity';

    private const OPEN_URI = [
        '/sign-up' => '',
        '/authorize' => '',
        '/access-token' => '',
        '/worker-holiday-schedule' => '',
        '/workers-schedule' => '',
    ];

    public function __construct(
        private ResourceServer $resourceServer,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
//            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $symfonyRequest = $event->getRequest();
        if (!$this->isOpenRoute($symfonyRequest->getRequestUri()))
        {
            $psrRequest = $this->createPsrRequest($symfonyRequest);

//            try {
                /** @var ServerRequestInterface $request */
                $request = $this->resourceServer->validateAuthenticatedRequest($psrRequest);
                $this->updateSymfonyRequest($symfonyRequest, $request);
//            } catch (OAuthServerException $exception) {
//                throw new UnauthorizedHttpException(
//                    $symfonyRequest->getRequestUri(),
//                    'Пользователь не авторизован.'
//                );
//            }
        }
    }

    private function isOpenRoute(string $uri): bool
    {
        $route = preg_replace("/\?.+/", "", $uri);

        return array_key_exists($route, self::OPEN_URI);
    }

    private function createPsrRequest(SymfonyRequest $request): ServerRequestInterface
    {
        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
        return $psrHttpFactory->createRequest($request);
    }

    private function updateSymfonyRequest(SymfonyRequest $originalRequest, ServerRequestInterface $psrRequest)
    {
        $userIdentity = new UserIdentity($psrRequest->getAttribute('oauth_user_id'));

        $originalRequest->attributes->set(self::USER_IDENTITY, $userIdentity);

        $originalRequest->attributes->set('oauth_access_token_id', $psrRequest->getAttribute('oauth_access_token_id'));
        $originalRequest->attributes->set('oauth_client_id', $psrRequest->getAttribute('oauth_client_id'));
        $originalRequest->attributes->set('oauth_user_id', $psrRequest->getAttribute('oauth_user_id'));
        $originalRequest->attributes->set('oauth_scopes', $psrRequest->getAttribute('oauth_scopes'));
    }
}
