<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ApiExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $response = [];

        // Handle NotFoundHttpException specifically
        if ($exception instanceof NotFoundHttpException) {
            $response = [
                'code' => 404,
                'message' => 'Resource introuvable.',
            ];
        } elseif ($exception instanceof HttpExceptionInterface) {
            // General HTTP exceptions
            $response = [
                'code' => $exception->getStatusCode(),
                'message' => $exception->getPropertyPath() .": " . $exception->getMessage(),
            ];
        } else {
            // Handle other exceptions
            $response = [
                'code' => 500,
                'message' => 'Une erreur est survenue.',
            ];
        }

        $event->setResponse(new JsonResponse($response, $response['code']));
    }
}