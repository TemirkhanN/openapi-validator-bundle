<?php

declare(strict_types=1);

namespace TemirkhanN\OpenapiValidatorBundle\Event;

use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use TemirkhanN\OpenapiValidatorBundle\Validator\ValidatorInterface;

class ValidateRequestSubscriber implements EventSubscriberInterface
{
    private ValidatorInterface $validator;
    private HttpMessageFactoryInterface $httpPsrBridge;

    public function __construct(ValidatorInterface $validator, HttpMessageFactoryInterface $httpPsrBridge)
    {
        $this->validator     = $validator;
        $this->httpPsrBridge = $httpPsrBridge;
    }

    public static function getSubscribedEvents(): array
    {
        $veryLowPriority = 10000;

        return [
            ResponseEvent::class => [
        'onResponse',
        $veryLowPriority,
            ],
        ];
    }

    public function onResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request  = $this->httpPsrBridge->createRequest($event->getRequest());
        $response = $this->httpPsrBridge->createResponse($event->getResponse());

        $this->validator->validate($request, $response);
    }
}
