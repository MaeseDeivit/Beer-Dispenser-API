<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usage\Domain;

use App\Tests\Shared\Domain\FloatMother;
use App\Usages\Domain\Model\UsageTotalSpent;

final class UsageTotalSpentMother
{
    public static function create(?float $value = null): UsageTotalSpent
    {
        return new UsageTotalSpent($value ?? FloatMother::create());
    }
}
