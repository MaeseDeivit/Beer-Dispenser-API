<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usage\Domain;

use DateTime;
use App\Shared\Domain\Uuid\UsageId;
use App\Shared\Domain\Uuid\DispenserId;
use App\Usages\Domain\Model\UsageTotalSpent;
use App\Dispensers\Domain\Model\DispenserFlowVolume;
use App\Tests\Unit\Dispenser\Domain\DispenserFlowVolumeMother;
use App\Usages\Domain\Model\Usage;

final class UsageMother
{
    public static function create(
        ?UsageId $id = null,
        ?DispenserId $dispenserId = null,
        ?DispenserFlowVolume $dispenserFlowVolume = null,
        ?UsageTotalSpent $totalSpent = null,
        ?DateTime $openedAt = null,
        ?DateTime $closedAt = null
    ): Usage {
        $now = $openedAt ?? new DateTime('now');
        $usage = new Usage(
            $id ?? UsageId::random(),
            $dispenserId ?? DispenserId::random(),
            $totalSpent ?? UsageTotalSpentMother::create(),
            $openedAt ?? $now,
            $closedAt ?? $now
        );
        $usage->setFlowVolume($dispenserFlowVolume ?? DispenserFlowVolumeMother::create());
        return $usage;
    }
}
