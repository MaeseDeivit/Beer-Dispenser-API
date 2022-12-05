<?php

declare(strict_types=1);

namespace App\Usages\Domain\Model\ValueObject;

use App\Shared\Domain\ValueObject\FloatValueObject;

final class UsageTotalSpent extends FloatValueObject
{
    public function __construct(float $value)
    {
        parent::__construct($value);
    }
}
