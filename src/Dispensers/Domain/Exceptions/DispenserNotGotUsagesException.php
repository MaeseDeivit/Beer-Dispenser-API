<?php

declare(strict_types=1);

namespace App\Dispensers\Domain\Exceptions;

use App\Shared\Domain\DomainError;
use Symfony\Component\HttpFoundation\Response;

final class DispenserNotGotUsagesException extends DomainError
{
    public function __construct(private readonly string $value)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 9304;
    }

    public function errorMessage(): string
    {
        return sprintf('The dispenser <%s> has not usages', $this->value);
    }
    public function errorStatusCode(): int
    {
        return Response::HTTP_CONFLICT;
    }
}
