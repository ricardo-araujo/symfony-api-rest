<?php

namespace App\EventSubscriber;

use App\Helper\EntityFactoryException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionHandlerSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'kernel.exception' => [
                ['onEntityException', 1],
                ['on404Exception', 0],
            ],
        ];
    }

    public function onEntityException(ExceptionEvent $event)
    {
        if ($event->getThrowable() instanceof EntityFactoryException) {
            $event->setResponse(
                new JsonResponse([
                    'success' => false,
                    'data' => [
                        'message' => $event->getThrowable()->getMessage()
                    ]
                ])
            );
        }
    }

    public function on404Exception(ExceptionEvent $event)
    {
        if ($event->getThrowable() instanceof NotFoundHttpException) {
            $event->setResponse(
                new JsonResponse([
                    'success' => false,
                    'data' => [
                        'message' => $event->getThrowable()->getMessage()
                    ]
                ])
            );
        }
    }
}
