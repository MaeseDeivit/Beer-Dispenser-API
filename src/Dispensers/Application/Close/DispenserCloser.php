<?php

declare(strict_types=1);

namespace App\Dispensers\Application\Close;

use DateTime;
use App\Shared\Domain\Uuid\UsageId;
use App\Shared\Domain\Uuid\DispenserId;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Usages\Application\Create\UsageCreator;
use App\Usages\Application\CompleteById\UsageCompleter;
use App\Dispensers\Domain\Exceptions\DispenserNotExistException;
use App\Usages\Infrastructure\Persistence\Repository\UsageRepository;
use App\Usages\Application\GetByDispenserId\UsagesByDispenserIdFinder;
use App\Dispensers\Infrastructure\Persistence\Repository\DispenserRepository;

final class DispenserCloser
{
    private readonly UsageCompleter $usageCompleter;
    private readonly UsagesByDispenserIdFinder $usagesByDispenserIdFinder;

    public function __construct(
        private readonly DispenserRepository $repository,
        private readonly UsageRepository $usageRepository,
        private readonly EventBus $bus
    ) {
        $this->usageCompleter = new UsageCompleter($usageRepository, $bus);
        $this->usagesByDispenserIdFinder = new UsagesByDispenserIdFinder($usageRepository);
    }

    public function __invoke(
        DispenserId $id
    ) {
        $now = new DateTime('now');
        $dispenser = $this->repository->search($id);
        if (is_null($dispenser)) {
            throw new DispenserNotExistException($id->value());
        }
        $usages = $this->usagesByDispenserIdFinder->__invoke($id);

        $incompleteUsageId = $dispenser->validateCloseDispenser($usages);

        $this->usageCompleter->__invoke($incompleteUsageId, $dispenser->flowVolume(), $now);
        
        $dispenser->changeStatusClose($now);

        $this->repository->save($dispenser);

        $this->bus->publish(...$dispenser->pullDomainEvents());
    }
}
