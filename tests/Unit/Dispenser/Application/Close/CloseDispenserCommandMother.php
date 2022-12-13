<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dispenser\Application\Close;

use App\Shared\Domain\Uuid\DispenserId;
use App\Dispensers\Application\Close\CloseDispenserCommand;

final class CloseDispenserCommandMother
{
    public static function create(
        ?DispenserId $id = null
    ): CloseDispenserCommand {
        return new CloseDispenserCommand(
            $id?->value() ?? DispenserId::random()->value()
        );
    }
}
