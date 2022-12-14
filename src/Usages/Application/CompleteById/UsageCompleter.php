<?php

declare(strict_types=1);

namespace App\Usages\Application\CompleteById;

use App\Dispensers\Domain\Model\DispenserFlowVolume;
use App\Shared\Domain\Uuid\UsageId;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Usages\Domain\Exceptions\UsageNotExistException;
use App\Usages\Domain\Repository\UsageRepositoryInterface;
use DateTime;

final class UsageCompleter
{

    public function __construct(private readonly UsageRepositoryInterface $repository, private readonly EventBus $bus)
    {
    }

    public function __invoke(
        UsageId $id,
        DispenserFlowVolume $dispenserFlowVolume,
        DateTime $closedAt
    ) {
        $usage = $this->repository->search($id);
        if (is_null($usage)) {
            throw new UsageNotExistException($id->value());
        }

        $usage->validateCompleteUsage();
        $usage->completedUsage($dispenserFlowVolume, $closedAt);

        $this->repository->save($usage);
        $this->bus->publish(...$usage->pullDomainEvents());
    }
}
