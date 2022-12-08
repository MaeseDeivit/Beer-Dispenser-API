<?php

declare(strict_types=1);

namespace App\Dispensers\Domain\Exceptions;

use App\Shared\Domain\DomainError;
use Symfony\Component\HttpFoundation\Response;

final class DispenserNotExistException extends DomainError
{
    public function __construct(private readonly string $value)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 301;
    }

    public function errorMessage(): string
    {
        return sprintf('The dispenser <%s> does not exist', $this->value);
    }

    public function errorStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
