<?php

namespace App\SharedKernel\Infrastructure\EventListeners;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class JsonDecoderListener
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->headers->has('Content-Type')) {
            /** @var string $contentType */
            $contentType = $request->headers->get('Content-Type', '');

            if (substr_count($contentType, 'application/json') > 0) {
                /** @var string $requestContent */
                $requestContent = $request->getContent();
                $data = json_decode($requestContent, true);

                if (is_array($data)) {
                    $request->request = new InputBag($data);
                    $this->logger->notice('Request Body', $data);
                }
            }
        }
    }
}
