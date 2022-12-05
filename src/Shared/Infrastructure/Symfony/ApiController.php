<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony;

use App\Shared\Domain\Bus\Query\Query;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\Bus\Query\Response;
use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Shared\Infrastructure\Symfony\ErrorJsonResponse;
use App\Shared\Infrastructure\Symfony\SuccessJsonResponse;

abstract class ApiController
{

    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly CommandBus $commandBus,
    ) {
    }

    protected function ask(Query $query): ?Response
    {
        return $this->queryBus->ask($query);
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }

    public function successResponse(int $httpCode = 200, mixed $data = null): JsonResponse
    {
        return SuccessJsonResponse::create(
            $httpCode,
            $data,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    public function errorResponse(int $httpCode, int $errorCode = 0, mixed $errorMessage = null): JsonResponse
    {
        return ErrorJsonResponse::create(
            $httpCode,
            [
                'errorCode' => $errorCode,
                'errorMessage' => $errorMessage
            ],
            ['Access-Control-Allow-Origin' => '*']
        );
    }
}
