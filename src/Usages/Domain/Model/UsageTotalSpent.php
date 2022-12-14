<?php

declare(strict_types=1);

namespace App\Usages\Domain\Model;

use App\Shared\Domain\ValueObject\FloatValueObjectNullable;

final class UsageTotalSpent extends FloatValueObjectNullable
{
    public function __construct(?float $value = null)
    {
        parent::__construct($value);
    }
}
