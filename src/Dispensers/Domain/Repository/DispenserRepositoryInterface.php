<?php

declare(strict_types=1);

namespace App\Dispensers\Domain\Repository;

use App\Dispensers\Domain\Model\Dispenser;

interface DispenserRepositoryInterface
{
    public function save(Dispenser $dispenser): void;

    /* public function update(Usage $dispenser): void;

    public function search(UsageId $id): ?Usage;

    public function searchAll(): array;*/
}
