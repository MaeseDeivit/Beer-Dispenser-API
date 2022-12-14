<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class ArrayValueObject
{
    protected $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function values(): array
    {
        return $this->values;
    }
    public function setValue($value): void
    {
        $this->values[] = $value;
    }
    public function __toString()
    {
        return $this->values();
    }
}
