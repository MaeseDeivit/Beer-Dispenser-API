<?php

declare(strict_types=1);

namespace App\Usages\Application\Create;

use DateTime;
use App\Shared\Domain\Uuid\UsageId;
use App\Shared\Domain\Uuid\DispenserId;
use App\Usages\Application\Create\UsageCreator;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Usages\Application\Create\CreateUsageCommand;

final class CreateUsageCommandHandler implements CommandHandler
{

    public function __construct(private readonly UsageCreator $creator)
    {
    }

    public function __invoke(CreateUsageCommand $command)
    {
        $id         = new UsageId($command->id());
        $dispenserId = new DispenserId($command->dispenserId());
        $createdAt = new DateTime($command->createdAt());

        $this->creator->__invoke($id, $dispenserId, $createdAt);
    }
}
