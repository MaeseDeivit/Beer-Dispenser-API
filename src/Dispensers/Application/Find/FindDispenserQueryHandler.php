<?php

declare(strict_types=1);

namespace App\Dispensers\Application\Find;

use App\Shared\Domain\Uuid\DispenserId;
use App\Shared\Domain\Bus\Query\QueryHandler;
use App\Dispensers\Application\DispenserResponse;
use App\Dispensers\Application\Find\DispenserFinder;

final class FindDispenserQueryHandler implements QueryHandler
{
    public function __construct(private readonly DispenserFinder $finder)
    {
    }

    public function __invoke(FindDispenserQuery $query): DispenserResponse
    {
        $dispenser = $this->finder->__invoke(new DispenserId($query->id()));

        return new DispenserResponse(
            $dispenser->id()->value(),
            $dispenser->flowVolume()->value(),
            $dispenser->totalAmount()->value(),
            $dispenser->status()->value(),
            $dispenser->createdOn()->format('Y-m-d H:i:s'),
            !is_null($dispenser->updatedOn()) ? $dispenser->updatedOn()->__toString() : null,
            $dispenser->usages()
        );
    }
}
