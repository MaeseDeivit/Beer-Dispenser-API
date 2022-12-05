<?php

declare(strict_types=1);

namespace App\Usages\Infrastructure\Persistence\Repository;

use Doctrine\DBAL\Exception;
use Psr\Log\LoggerInterface;
use App\Usages\Domain\Model\Usage;
use App\Usages\Domain\Repository\UsageRepositoryInterface;
use App\Health\Domain\Repository\Exceptions\DatabaseNotHealthyRepositoryException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UsageRepository extends ServiceEntityRepository implements UsageRepositoryInterface
{
    private LoggerInterface $logger;

    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Usage::class);
        $this->logger = $logger;
    }

    public function save(Usage $usage): void
    {
        try {
            $this->_em->persist($usage);
            $this->_em->flush();
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw new DatabaseNotHealthyRepositoryException($e->getMessage());
        }
    }
}
