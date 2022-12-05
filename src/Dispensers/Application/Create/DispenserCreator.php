<?php

declare(strict_types=1);

namespace App\Dispensers\Application\Create;

use App\Dispensers\Domain\Model\Dispenser;
use App\Dispensers\Domain\Model\ValueObject\DispenserFlowVolume;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Dispensers\Infrastructure\Persistence\Repository\DispenserRepository;
use App\Shared\Domain\Uuid\DispenserId;

final class DispenserCreator
{

    public function __construct(private readonly DispenserRepository $repository, private readonly EventBus $bus)
    {
    }

    public function __invoke(
        DispenserId $id,
        DispenserFlowVolume $flowVolume
    ) {
        $dispenser = Dispenser::create($id, $flowVolume);

        $this->repository->save($dispenser);
        $this->bus->publish(...$dispenser->pullDomainEvents());
    }
}
