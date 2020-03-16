<?php

namespace Mateu\EventListener;

use Mateu\Backend\Explotation\Application\Delete\NotEmptyExplotationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();
        $message = json_encode([
            'success' => false,
            'message' => $exception->getMessage()
        ]);
        //$message = null;

        // Customize your response object to display the exception details
        $response = new Response();

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        switch (true) {
            case $exception instanceof HttpExceptionInterface :
                $response->setStatusCode($exception->getStatusCode());
                $response->headers->replace($exception->getHeaders());
                break;
            case $exception instanceof \PDOException:
                $message = json_encode([
                    'success' => false,
                    'message' => 'Something went wrong :('
                ]);
                break;
            default:
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

        }
        /*if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }*/

        // sends the modified response object to the event
        $response->setContent($message);
        $event->setResponse($response);
    }
}