<?php

declare(strict_types=1);

namespace App\Dispensers\Domain\Model;

use InvalidArgumentException;
use App\Shared\Domain\ValueObject\Enum;


final class DispenserStatus extends Enum
{
    public const OPEN         = 'open';
    public const CLOSE        = 'close';

    public function isNone(): bool
    {
        return $this->equals(self::none());
    }

    protected function throwExceptionForInvalidValue($value): void
    {
        throw new InvalidArgumentException('Invalid dispenser status: ' . $value, 2503);
    }
}
