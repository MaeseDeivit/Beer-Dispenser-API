<?php

namespace App\Health\Infrastructure\Api;

use App\Health\Application\GetHealthResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Shared\Infrastructure\Symfony\ApiController;
use App\Health\Application\CheckHealth\CheckHealthQuery;
use App\Health\Domain\Repository\Exceptions\DatabaseNotHealthyRepositoryException;

class HealthController extends ApiController
{
    public function __invoke(): Response
    {
        /** @var GetHealthResponse $response */
        $response = $this->ask(new CheckHealthQuery());
        return ($response->getStatus() > 0) ? $this->successResponse(Response::HTTP_OK, $response->getMessage()) : $this->errorResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    protected function exceptions(): array
    {
        return [
            DatabaseNotHealthyRepositoryException::class => Response::HTTP_INTERNAL_SERVER_ERROR,
            HealthRepositoryException::class => Response::HTTP_INTERNAL_SERVER_ERROR,
        ];
    }
}
