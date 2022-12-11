<?php

declare(strict_types=1);

namespace App\Dispensers\Domain\Model;

use App\Shared\Domain\ValueObject\FloatValueObject;

final class DispenserTotalAmount extends FloatValueObject
{
    public function __construct(float $value)
    {
        parent::__construct($value);
    }
}
