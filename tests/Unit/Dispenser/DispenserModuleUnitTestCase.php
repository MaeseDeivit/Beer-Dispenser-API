<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dispenser;

use App\Shared\Domain\Uuid\DispenserId;
use App\Dispensers\Domain\Model\Dispenser;
use PHPUnit\Framework\MockObject\MockObject;
use App\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use App\Usages\Domain\Repository\UsageRepositoryInterface;
use App\Dispensers\Domain\Repository\DispenserRepositoryInterface;

abstract class DispenserModuleUnitTestCase extends UnitTestCase
{
    private $repository;
    private $repositoryUsage;


    protected function shouldSave(Dispenser $dispenser): void
    {
        $this->repository()
            ->method('save')
            ->withAnyParameters();
        //->with($dispenser);
    }

    protected function shouldSearch(?Dispenser $dispenser): void
    {
        $this->repository()
            ->method('search')
            ->willReturn($dispenser);
    }

    protected function shouldFind(DispenserId $id, ?Dispenser $dispenser): void
    {
        $this->repository()
            ->method('search')
            ->with($id)
            ->willReturn($dispenser);
    }

    /** return DispenserRepositoryInterface|MockObject */
    protected function repository(): DispenserRepositoryInterface|MockObject
    {
        return $this->repository = $this->repository ?: $this->createMock(DispenserRepositoryInterface::class);
    }

    /** return UsageRepositoryInterface|MockObject */
    protected function repositoryUsage(): UsageRepositoryInterface|MockObject
    {
        return $this->repositoryUsage = $this->repositoryUsage ?: $this->createMock(UsageRepositoryInterface::class);
    }
}
