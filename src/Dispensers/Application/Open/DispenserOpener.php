<?php

declare(strict_types=1);

namespace App\Dispensers\Application\Open;

use DateTime;
use App\Shared\Domain\Uuid\DispenserId;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Usages\Application\Create\UsageCreator;
use App\Dispensers\Domain\Exceptions\DispenserNotExistException;
use App\Usages\Infrastructure\Persistence\Repository\UsageRepository;
use App\Dispensers\Infrastructure\Persistence\Repository\DispenserRepository;
use App\Shared\Domain\Uuid\UsageId;

final class DispenserOpener
{
    private readonly UsageCreator $usageCreator;

    public function __construct(
        private readonly DispenserRepository $repository,
        private readonly UsageRepository $usageRepository,
        private readonly EventBus $bus
    ) {
        $this->usageCreator = new UsageCreator($usageRepository, $bus);
    }

    public function __invoke(
        DispenserId $id
    ) {
        $now = new DateTime('now');
        $dispenser = $this->repository->search($id);
        if (is_null($dispenser)) {
            throw new DispenserNotExistException($id->value());
        }
        $dispenser->validateOpenDispenser();

        $this->usageCreator->__invoke(UsageId::random(), $id, $now);

        $dispenser->changeStatusOpen($now);

        $this->repository->save($dispenser);

        $this->bus->publish(...$dispenser->pullDomainEvents());
    }
}
