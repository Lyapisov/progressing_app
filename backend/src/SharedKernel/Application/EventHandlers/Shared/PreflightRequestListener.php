<?php

namespace App\SharedKernel\Application\EventHandlers\Shared;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class PreflightRequestListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        $request = $event->getRequest();
        $method = $request->getRealMethod();

        if ('OPTIONS' == $method) {
            $response = new Response('Preflight response');
            $event->setResponse($response);
        }
    }
}
