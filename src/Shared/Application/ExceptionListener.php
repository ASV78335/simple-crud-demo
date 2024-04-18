<?php

namespace App\Shared\Application;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    private array $defaultExceptions = [
        'App\Shared\Application\RequestBodyConvertException',
        'App\Shared\Domain\BusinessLogicException'
    ];

    public function __invoke(ExceptionEvent $event):void
    {
        $request = $event->getRequest();
        $throwable = $event->getThrowable();

        $exceptionClass = get_class($throwable);
        if (in_array($exceptionClass, $this->defaultExceptions)) {

            $response = new Response(
                json_encode($throwable->getMessage()),
                Response::HTTP_BAD_REQUEST,
                ['content-type' => 'application/json']
            );

            $response->prepare($request);
            $event->setResponse($response);
        }

        if ($throwable instanceof ValidationException) {

            $message = $throwable->getMessage() . '.  ';

            $firstViolation = $throwable->getViolations()->get(0);
            $message .= $firstViolation->getPropertyPath() . ':  ' . $firstViolation->getMessage();
            $response = new Response(
                json_encode($message),
                Response::HTTP_BAD_REQUEST,
                ['content-type' => 'application/json']
            );

            $response->prepare($request);
            $event->setResponse($response);
        }
    }
}
