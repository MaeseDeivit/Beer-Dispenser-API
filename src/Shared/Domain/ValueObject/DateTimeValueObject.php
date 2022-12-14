<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use DateTimeZone;
use DateTime;
use DateTimeInterface;

abstract class DateTimeValueObject
{
    protected $value;

    public function __construct(string $value)
    {
        try {
            $this->value = new DateTime($value, new DateTimeZone('UTC'));
        } catch (\Throwable $th) {
            throw new \InvalidArgumentException("<$value> is not a valid DateTime format", 9005);
        }
    }

    public function value(): ?DateTime
    {
        return $this->value;
    }

    public function withFormat($format): string
    {
        return $this->value->format($format);
    }
    public function valueString(): ?string
    {
        return (null !== $this->value()) ? $this->value()->format(DateTimeInterface::ATOM) : null;
    }

    public function __toString()
    {
        return $this->value()->format(DateTimeInterface::ATOM);
    }
}
