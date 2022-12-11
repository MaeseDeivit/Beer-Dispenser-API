<?php

declare(strict_types=1);

namespace App\Usages\Domain\Exceptions;

use App\Shared\Domain\DomainError;
use Symfony\Component\HttpFoundation\Response;

final class UsageNotExistException extends DomainError
{
    public function __construct(private readonly string $value)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 401;
    }

    public function errorMessage(): string
    {
        return sprintf('The usage <%s> does not exist', $this->value);
    }

    public function errorStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
