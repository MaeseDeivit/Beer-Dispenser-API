<?php

declare(strict_types=1);

namespace App\Dispensers\Application\Find;

use App\Shared\Domain\Uuid\DispenserId;
use App\Dispensers\Domain\Model\Dispenser;
use App\Usages\Domain\Repository\UsageRepositoryInterface;
use App\Dispensers\Domain\Exceptions\DispenserNotExistException;
use App\Dispensers\Domain\Repository\DispenserRepositoryInterface;
use App\Usages\Application\GetByDispenserId\UsagesByDispenserIdFinder;

final class DispenserFinder
{
    private readonly UsagesByDispenserIdFinder $usagesFinder;

    public function __construct(
        private readonly DispenserRepositoryInterface $repository,
        private readonly UsageRepositoryInterface $usageRepository
    ) {
        $this->usagesFinder = new UsagesByDispenserIdFinder($usageRepository);
    }

    public function __invoke(DispenserId $id): Dispenser
    {
        $dispenser = $this->repository->search($id);

        if (is_null($dispenser)) {
            throw new DispenserNotExistException($id->value());
        }
        $dispenser->setUsages($this->usagesFinder->__invoke($id)??[]);
        $dispenser->calculateSpending();

        return $dispenser;
    }
}
