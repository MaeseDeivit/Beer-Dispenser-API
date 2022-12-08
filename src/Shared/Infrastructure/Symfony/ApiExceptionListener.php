<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony;

use Throwable;
use App\Shared\Domain\Utils;
use App\Shared\Domain\DomainError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use App\Shared\Infrastructure\Symfony\ApiExceptionsHttpStatusCodeMapping;

final class ApiExceptionListener
{
    public function __construct(private readonly ApiExceptionsHttpStatusCodeMapping $exceptionHandler)
    {
    }

    public function onException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $event->setResponse(
            new JsonResponse(
                [
                    'errorCode'    => $this->exceptionCodeFor($exception),
                    'errorMessage' => $exception->getMessage(),
                ],
                $this->exceptionHandler->statusCodeFor($exception::class)
            )
        );
    }

    private function exceptionCodeFor(Throwable $error): int
    {
        $domainErrorClass = DomainError::class;

        return $error instanceof $domainErrorClass
            ? $error->errorCode()
            : Utils::toSnakeCase(Utils::extractClassName($error));
    }
}
