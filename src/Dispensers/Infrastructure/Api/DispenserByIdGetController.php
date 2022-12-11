<?php

declare(strict_types=1);

namespace App\Dispensers\Infrastructure\Api;

use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use App\Dispensers\Application\DispenserResponse;
use App\Shared\Infrastructure\Symfony\ApiController;
use App\Dispensers\Application\Find\FindDispenserQuery;
use App\Dispensers\Domain\Exceptions\DispenserNotExistException;

final class DispenserByIdGetController extends ApiController
{
    public function __invoke(string $id): Response
    {
        if (!Uuid::isValid($id)) {
            return $this->errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, 9000, 'Not valid UUID format');
        }

        /** @var DispenserResponse $response */
        $response = $this->ask(new FindDispenserQuery($id));

        return $this->successResponse(Response::HTTP_OK,  $response->values());
    }

    protected function exceptions(): array
    {
        return [
            DispenserNotExistException::class => Response::HTTP_NOT_FOUND,
        ];
    }
}
