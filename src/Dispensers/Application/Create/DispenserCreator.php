<?php

declare(strict_types=1);

namespace App\Dispensers\Application\Create;

use App\Shared\Domain\Uuid\DispenserId;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Dispensers\Domain\Model\Dispenser;
use App\Dispensers\Domain\Model\DispenserFlowVolume;
use App\Dispensers\Domain\Repository\DispenserRepositoryInterface;
use App\Dispensers\Domain\Exceptions\DispenserAlreadyExistsException;

final class DispenserCreator
{

    public function __construct(
        private readonly DispenserRepositoryInterface $repository,
        private readonly EventBus $bus
    ) {
    }

    public function __invoke(
        DispenserId $id,
        DispenserFlowVolume $flowVolume
    ) {
        if (!is_null($this->repository->search($id))) {
            throw new DispenserAlreadyExistsException($id->value());
        }

        $dispenser = Dispenser::create($id, $flowVolume);

        $this->repository->save($dispenser);
        $this->bus->publish(...$dispenser->pullDomainEvents());
    }
}
