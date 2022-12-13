<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dispenser\Domain;

use App\Dispensers\Domain\Model\DispenserFlowVolume;
use App\Tests\Shared\Domain\FloatMother;

final class DispenserFlowVolumeMother
{
    public static function create(?float $value = null): DispenserFlowVolume
    {
        return new DispenserFlowVolume($value ?? FloatMother::create());
    }
}
