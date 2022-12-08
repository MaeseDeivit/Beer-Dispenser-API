<?php

declare(strict_types=1);

namespace App\Dispensers\Infrastructure\Persistence\Repository;

use Doctrine\DBAL\Exception;
use App\Dispensers\Domain\Model\Dispenser;
use App\Dispensers\Domain\Repository\DispenserRepositoryInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use App\Health\Domain\Repository\Exceptions\DatabaseNotHealthyRepositoryException;

class DispenserRepository extends DoctrineRepository implements DispenserRepositoryInterface
{
    public function save(Dispenser $dispenser): void
    {
        try {
            $this->persist($dispenser);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
