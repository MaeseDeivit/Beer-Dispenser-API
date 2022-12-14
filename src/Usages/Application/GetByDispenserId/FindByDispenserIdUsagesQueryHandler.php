<?php

declare(strict_types=1);

namespace App\Usages\Application\GetByDispenserId;

use App\Shared\Domain\Uuid\DispenserId;
use App\Shared\Domain\Bus\Query\QueryHandler;
use App\Usages\Application\GetByDispenserId\UsagesByDispenserIdFinder;
use App\Usages\Application\GetByDispenserId\FindByDispenserIdUsagesQuery;

final class FindByDispenserIdUsagesQueryHandler implements QueryHandler
{
    public function __construct(private readonly UsagesByDispenserIdFinder $finder)
    {
    }

    public function __invoke(FindByDispenserIdUsagesQuery $query): array
    {
        return  $this->finder->__invoke(new DispenserId($query->dispenserId())) ?? [];
    }
}
