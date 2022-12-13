<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dispenser\Application\Open;

use App\Shared\Domain\Uuid\DispenserId;
use App\Dispensers\Application\Open\OpenDispenserCommand;

final class OpenDispenserCommandMother
{
    public static function create(
        ?DispenserId $id = null
    ): OpenDispenserCommand {
        return new OpenDispenserCommand(
            $id?->value() ?? DispenserId::random()->value()
        );
    }
}
