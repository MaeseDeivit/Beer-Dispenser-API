<?php

declare(strict_types=1);

namespace App\Usages\Application\GetByDispenserId;

use App\Shared\Domain\Uuid\DispenserId;
use App\Usages\Domain\Repository\UsageRepositoryInterface;

final class UsagesByDispenserIdFinder
{
    public function __construct(private readonly UsageRepositoryInterface $repository)
    {
    }

    public function __invoke(DispenserId $dispenserId): array
    {
        return $this->repository->searchByDispenserId($dispenserId) ?? [];
    }
}
