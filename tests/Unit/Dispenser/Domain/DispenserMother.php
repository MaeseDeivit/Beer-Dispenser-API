<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dispenser\Domain;

use DateTime;
use App\Shared\Domain\Uuid\DispenserId;
use App\Dispensers\Domain\Model\Dispenser;
use App\Dispensers\Domain\Model\DispenserStatus;
use App\Dispensers\Domain\Model\DispenserFlowVolume;
use App\Dispensers\Domain\Model\DispenserTotalAmount;

final class DispenserMother
{
    public static function create(
        ?DispenserId $id = null,
        ?DispenserFlowVolume $flowVolume = null,
        ?DispenserTotalAmount $totalAmount = null,
        ?DispenserStatus $status = null,
        ?DateTime $createdOn = null,
        ?DateTime $updatedOn = null,
        ?array $usages = null
    ): Dispenser {
        $now = $createdOn ?? new DateTime('now');
        $dispenser = new Dispenser(
            $id ?? DispenserId::random(),
            $flowVolume ?? DispenserFlowVolumeMother::create(),
            $status ?? DispenserStatus::random(),
            $createdOn ?? $now,
            $updatedOn ?? $now,
            $usages ?? []
        );
        $dispenser->setTotalAmount($totalAmount ?? DispenserTotalAmountMother::create(0));
        return $dispenser;
    }
}
