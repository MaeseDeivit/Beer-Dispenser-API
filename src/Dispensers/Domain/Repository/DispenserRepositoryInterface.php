<?php

declare(strict_types=1);

namespace App\Dispensers\Domain\Repository;

use App\Dispensers\Domain\Model\Dispenser;
use App\Shared\Domain\Uuid\DispenserId;

interface DispenserRepositoryInterface
{
    public function save(Dispenser $dispenser): void;

    public function search(DispenserId $id): ?Dispenser;

    /* public function update(Usage $dispenser): void;

    public function search(UsageId $id): ?Usage;

    public function searchAll(): array;*/
}
