<?php

declare(strict_types=1);

namespace App\Dispensers\Application\Open;

use App\Shared\Domain\Uuid\DispenserId;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Dispensers\Application\Find\DispenserFinder;
use App\Dispensers\Domain\Exceptions\DispenserAlreadyExistsException;
use App\Dispensers\Infrastructure\Persistence\Repository\DispenserRepository;

final class DispenserOpener
{
    public function __construct(private readonly DispenserRepository $repository, private readonly EventBus $bus)
    {
    }

    public function __invoke(
        DispenserId $id
    ) {
        if (!is_null($this->repository->search($id))) {
            throw new DispenserAlreadyExistsException($id->value());
        }

        $dispenser = $this->finder->__invoke($id);

        //  $this->repository->save($dispenser);
        //  $this->bus->publish(...$dispenser->pullDomainEvents());
    }
}
