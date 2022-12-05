<?php

declare(strict_types = 1);

namespace App\Shared\Domain\ValueObject;

abstract class IntegerValueObject
{
    protected int $value;

    public function __construct(int $value)
    {
        $this->value = $value;        
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }
}