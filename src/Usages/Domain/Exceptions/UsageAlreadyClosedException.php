<?php

declare(strict_types=1);

namespace App\Usages\Domain\Exceptions;

use App\Shared\Domain\DomainError;
use Symfony\Component\HttpFoundation\Response;

final class UsageAlreadyClosedException extends DomainError
{
    public function __construct(private readonly string $value)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 9402;
    }

    public function errorMessage(): string
    {
        return sprintf('The usage <%s> already closed and completed', $this->value);
    }
    public function errorStatusCode(): int
    {
        return Response::HTTP_CONFLICT;
    }
}
