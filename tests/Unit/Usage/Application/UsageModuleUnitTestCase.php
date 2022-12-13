<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usage\Application;

use App\Shared\Domain\Uuid\DispenserId;
use App\Usages\Domain\Model\Usage;
use App\Shared\Domain\Uuid\UsageId;
use PHPUnit\Framework\MockObject\MockObject;
use App\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use App\Usages\Domain\Repository\UsageRepositoryInterface;

abstract class UsageModuleUnitTestCase extends UnitTestCase
{
    private $repository;


    protected function shouldSave(Usage $usage): void
    {
        $this->repository()
            ->method('save')
            ->withAnyParameters();
        //->with($usage);
    }

    protected function shouldSearch(?Usage $usage): void
    {
        $this->repository()
            ->method('search')
            ->willReturn($usage);
    }

    protected function shouldFind(UsageId $id, ?Usage $usage): void
    {
        $this->repository()
            ->method('search')
            ->with($id)
            ->willReturn($usage);
    }

    protected function shouldSearchByDispenserId(DispenserId $dispenserId, ?array $usages = []): void
    {
        $this->repository()
            ->method('searchByDispenserId')
            ->with($dispenserId)
            ->willReturn($usages);
    }

    /** return UsageRepositoryInterface|MockObject */
    protected function repository(): UsageRepositoryInterface|MockObject
    {
        return $this->repository = $this->repository ?: $this->createMock(UsageRepositoryInterface::class);
    }
}
