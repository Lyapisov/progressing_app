<?php

namespace App\SharedKernel\Infrastructure\EventListeners;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

class CORSListener
{
    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        // TODO: Configure certain domains
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, AUTHORIZATION');
    }
}
