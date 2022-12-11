<?php

declare(strict_types=1);

namespace App\Dispensers\Infrastructure\Persistence\Repository;

use App\Dispensers\Domain\Model\Dispenser;
use App\Dispensers\Domain\Repository\DispenserRepositoryInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use App\Shared\Domain\Uuid\DispenserId;

class DispenserRepository extends DoctrineRepository implements DispenserRepositoryInterface
{
    public function save(Dispenser $dispenser): void
    {
        $this->persist($dispenser);
    }
    public function search(DispenserId $id): ?Dispenser
    {
        return $this->repository(Dispenser::class)->find($id);
    }
}
