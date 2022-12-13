<?php

declare(strict_types=1);

namespace App\Usages\Application\CompleteById;

use App\Dispensers\Domain\Model\DispenserFlowVolume;
use DateTime;
use App\Shared\Domain\Uuid\UsageId;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Usages\Application\CompleteById\UsageCompleter;
use App\Usages\Application\CompleteById\CompleteByIdUsageCommand;

final class CompleteByIdUsageCommandHandler implements CommandHandler
{

    public function __construct(private readonly UsageCompleter $completer)
    {
    }

    public function __invoke(CompleteByIdUsageCommand $command)
    {
        $id         = new UsageId($command->id());
        $dispenserFlowVolume = new DispenserFlowVolume($command->dispenserFlowVolume());
        $closedAt = new DateTime($command->closedAt());

        $this->completer->__invoke($id, $dispenserFlowVolume, $closedAt);
    }
}
