<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

use App\Exception\BusinessLogicException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $response = [
            'code' => 500,
            'message' => 'Internal Server Error',
        ];

        if (
            $exception instanceof HttpExceptionInterface ||
            $exception instanceof BusinessLogicException
        ) {
            $response['code'] = $exception->getStatusCode();
            $response['message'] = $exception->getMessage();
        }

        $event->setResponse(new JsonResponse($response, $response['code']));
    }
}
