<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dispenser\Domain;

use App\Dispensers\Domain\Model\DispenserTotalAmount;
use App\Tests\Shared\Domain\FloatMother;

final class DispenserTotalAmountMother
{
    public static function create(?float $value = null): DispenserTotalAmount
    {
        return new DispenserTotalAmount($value ?? FloatMother::create());
    }
}
