<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dispenser\Application\Create;

use App\Shared\Domain\Uuid\DispenserId;
use App\Dispensers\Domain\Model\DispenserFlowVolume;
use App\Dispensers\Application\Create\CreateDispenserCommand;
use App\Tests\Unit\Dispenser\Domain\DispenserFlowVolumeMother;

final class CreateDispenserCommandMother
{
    public static function create(
        ?DispenserId $id = null,
        ?DispenserFlowVolume $flowVolume = null
    ): CreateDispenserCommand {
        return new CreateDispenserCommand(
            $id?->value() ?? DispenserId::random()->value(),
            $flowVolume?->value() ?? DispenserFlowVolumeMother::create()->value()
        );
    }
}
