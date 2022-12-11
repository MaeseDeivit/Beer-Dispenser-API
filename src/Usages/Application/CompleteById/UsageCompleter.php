<?php

declare(strict_types=1);

namespace App\Usages\Application\CompleteById;

use App\Dispensers\Domain\Model\DispenserFlowVolume;
use App\Usages\Domain\Model\Usage;
use App\Shared\Domain\Uuid\UsageId;
use App\Shared\Domain\Uuid\DispenserId;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Usages\Domain\Exceptions\UsageAlreadyExistsException;
use App\Usages\Domain\Exceptions\UsageNotExistException;
use App\Usages\Infrastructure\Persistence\Repository\UsageRepository;
use DateTime;

final class UsageCompleter
{

    public function __construct(private readonly UsageRepository $repository, private readonly EventBus $bus)
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
