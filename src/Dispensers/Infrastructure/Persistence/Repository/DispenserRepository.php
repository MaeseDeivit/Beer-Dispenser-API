<?php

declare(strict_types=1);

namespace App\Dispensers\Infrastructure\Persistence\Repository;

use App\Dispensers\Domain\Model\Dispenser;
use Doctrine\DBAL\Exception;
use Psr\Log\LoggerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Dispensers\Domain\Repository\DispenserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Health\Domain\Repository\Exceptions\DatabaseNotHealthyRepositoryException;

class DispenserRepository extends ServiceEntityRepository implements DispenserRepositoryInterface
{
    private LoggerInterface $logger;

    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Dispenser::class);
        $this->logger = $logger;
    }

    public function save(Dispenser $dispenser): void
    {
        try {
            $this->_em->persist($dispenser);
            $this->_em->flush();
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw new DatabaseNotHealthyRepositoryException($e->getMessage());
        }
    }
}
