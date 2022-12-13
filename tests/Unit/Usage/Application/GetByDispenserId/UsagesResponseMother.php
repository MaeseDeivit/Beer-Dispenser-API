<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usage\Application\GetByDispenserId;

use App\Dispensers\Application\DispenserResponse;
use App\Dispensers\Domain\Model\DispenserFlowVolume;
use App\Dispensers\Domain\Model\DispenserStatus;
use App\Dispensers\Domain\Model\DispenserTotalAmount;
use App\Shared\Domain\Uuid\DispenserId;
use App\Tests\Unit\Dispenser\Domain\DispenserFlowVolumeMother;
use App\Tests\Unit\Dispenser\Domain\DispenserTotalAmountMother;
use DateTime;

final class UsagesResponseMother
{
    public static function create(
        ?DispenserId $id = null,
        ?DispenserFlowVolume $flowVolume = null,
        ?DispenserTotalAmount $totalAmount = null,
        ?DispenserStatus $status = null,
        ?DateTime $createdOn = null,
        ?DateTime $updatedOn = null,
        ?array $usages = null
    ): DispenserResponse {
        $now = $createdOn?->format('Y-m-d H:i:s') ?? new DateTime('now');
        return new DispenserResponse(
            $id?->value() ?? DispenserId::random()->value(),
            $flowVolume?->value() ?? DispenserFlowVolumeMother::create()->value(),
            $totalAmount?->value() ?? DispenserTotalAmountMother::create(0),
            $status?->value() ?? DispenserStatus::random()->value(),
            $createdOn?->format('Y-m-d H:i:s') ?? $now->format('Y-m-d H:i:s'),
            $updatedOn?->format('Y-m-d H:i:s') ?? $now->format('Y-m-d H:i:s'),
            $usages ?? []
        );
    }
}
