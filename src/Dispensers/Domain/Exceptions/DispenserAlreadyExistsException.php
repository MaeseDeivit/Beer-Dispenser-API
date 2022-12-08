<?php

declare(strict_types=1);

namespace App\Dispensers\Domain\Exceptions;

use App\Shared\Domain\DomainError;

final class DispenserAlreadyExistsException extends DomainError
{
    public function __construct(private readonly string $value)
    {
        parent::__construct();
    }

    public function errorCode(): int
    {
        return 300;
    }

    public function errorMessage(): string
    {
        return sprintf('The dispenser <%s> already exists', $this->value);
    }
}
