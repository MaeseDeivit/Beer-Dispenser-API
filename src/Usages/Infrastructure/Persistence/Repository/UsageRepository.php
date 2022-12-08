<?php

declare(strict_types=1);

namespace App\Usages\Infrastructure\Persistence\Repository;

use Doctrine\DBAL\Exception;
use App\Usages\Domain\Model\Usage;
use App\Usages\Domain\Repository\UsageRepositoryInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class UsageRepository extends DoctrineRepository implements UsageRepositoryInterface
{
    public function save(Usage $usage): void
    {
        try {
            $this->persist($usage);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
