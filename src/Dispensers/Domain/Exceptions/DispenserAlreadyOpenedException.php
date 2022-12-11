<?php

declare(strict_types=1);

namespace App\Dispensers\Domain\Exceptions;

use App\Shared\Domain\DomainError;
use Symfony\Component\HttpFoundation\Response;

final class DispenserAlreadyOpenedException extends DomainError
{
    public function __construct(private readonly string $value)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 302;
    }

    public function errorMessage(): string
    {
        return sprintf('The dispenser <%s> is already opened', $this->value);
    }
    public function errorStatusCode(): int
    {
        return Response::HTTP_CONFLICT;
    }
}
