<?php

declare(strict_types=1);

namespace App\Dispensers\Domain\Exceptions;

use App\Shared\Domain\DomainError;

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
}
