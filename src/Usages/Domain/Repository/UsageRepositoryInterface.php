<?php

declare(strict_types=1);

namespace App\Usages\Domain\Repository;

use App\Shared\Domain\Uuid\DispenserId;
use App\Usages\Domain\Model\Usage;
use App\Shared\Domain\Uuid\UsageId;

interface UsageRepositoryInterface
{
    public function save(Usage $usage): void;

    public function search(UsageId $id): ?Usage;

    public function searchByDispenserId(DispenserId $dispenserId): ?array;

    /* public function update(Usage $usage): void;

    public function searchAll(): array;*/
}
