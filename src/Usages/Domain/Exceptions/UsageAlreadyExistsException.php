<?php

declare(strict_types=1);

namespace App\Usages\Domain\Exceptions;

use App\Shared\Domain\DomainError;
use Symfony\Component\HttpFoundation\Response;

final class UsageAlreadyExistsException extends DomainError
{
    public function __construct(private readonly string $value)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return sprintf('The usage <%s> already exists', $this->value);
    }
    public function errorStatusCode(): int
    {
        return Response::HTTP_CONFLICT;
    }

}
