<?php

declare(strict_types=1);

namespace App\Dispensers\Application\Find;

use DateTime;
use App\Shared\Domain\Uuid\DispenserId;
use App\Usages\Application\UsageResponse;
use App\Dispensers\Application\DispenserResponse;
use App\Dispensers\Domain\Exceptions\DispenserNotExistException;
use App\Dispensers\Domain\Model\Dispenser;
use App\Usages\Infrastructure\Persistence\Repository\UsageRepository;
use App\Usages\Application\GetByDispenserId\UsagesByDispenserIdFinder;
use App\Dispensers\Infrastructure\Persistence\Repository\DispenserRepository;

final class DispenserFinder
{
    private readonly UsagesByDispenserIdFinder $usagesFinder;

    public function __construct(
        private readonly DispenserRepository $repository,
        private readonly UsageRepository $usageRepository
    ) {
        $this->usagesFinder = new UsagesByDispenserIdFinder($usageRepository);
    }

    public function __invoke(DispenserId $id): Dispenser
    {
        $dispenser = $this->repository->search($id);

        if (is_null($dispenser)) {
            throw new DispenserNotExistException($id->value());
        }
        $dispenser->setUsages($this->usagesFinder->__invoke($id));
        $dispenser->calculateSpending();

        return $dispenser;
    }
}
