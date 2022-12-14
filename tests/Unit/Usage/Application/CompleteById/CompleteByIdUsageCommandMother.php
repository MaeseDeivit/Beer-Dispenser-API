<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usage\Application\CompleteById;

use App\Dispensers\Domain\Model\DispenserFlowVolume;
use DateTime;
use App\Shared\Domain\Uuid\UsageId;
use App\Tests\Unit\Dispenser\Domain\DispenserFlowVolumeMother;
use App\Usages\Application\CompleteById\CompleteByIdUsageCommand;

final class CompleteByIdUsageCommandMother
{
    public static function create(
        ?UsageId $id = null,
        ?DispenserFlowVolume $dispenserFlowVolume = null,
        ?DateTime $closedAt = null
    ): CompleteByIdUsageCommand {
        $now = $closedAt?->format('Y-m-d H:i:s') ?? new DateTime('now');
        return new CompleteByIdUsageCommand(
            $id?->value() ?? UsageId::random()->value(),
            $dispenserFlowVolume?->value() ?? DispenserFlowVolumeMother::create()->value(),
            $closedAt?->format('Y-m-d H:i:s') ?? $now->format('Y-m-d H:i:s'),
        );
    }
}
