<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class FloatValueObjectNullable
{
    protected ?float $value = null;

    public function __construct(?float $value = null)
    {
        $this->value = $value;
    }

    public function value(): ?float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }
}
