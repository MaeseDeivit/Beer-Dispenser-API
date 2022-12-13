<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usage\Application\Create;

use App\Shared\Domain\Uuid\DispenserId;
use App\Shared\Domain\Uuid\UsageId;
use App\Usages\Application\Create\CreateUsageCommand;
use DateTime;

final class CreateUsageCommandMother
{
    public static function create(
        ?UsageId $id = null,
        ?DispenserId $dispenserId = null,
        ?DateTime $openedAt = null
    ): CreateUsageCommand {
        $now = $openedAt?->format('Y-m-d H:i:s') ?? new DateTime('now');
        return new CreateUsageCommand(
            $id?->value() ?? UsageId::random()->value(),
            $dispenserId?->value() ?? DispenserId::random()->value(),
            $openedAt?->format('Y-m-d H:i:s') ?? $now->format('Y-m-d H:i:s'),
        );
    }
}
