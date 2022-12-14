<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usage\Application\CompleteById;

use App\Shared\Domain\Bus\Event\EventBus;
use App\Tests\Unit\Usage\Domain\UsageMother;
use App\Usages\Application\CompleteById\UsageCompleter;
use App\Usages\Domain\Exceptions\UsageNotExistException;
use App\Tests\Unit\Usage\Application\UsageModuleUnitTestCase;
use App\Usages\Domain\Exceptions\UsageAlreadyClosedException;
use App\Usages\Application\CompleteById\CompleteByIdUsageCommandHandler;
use App\Tests\Unit\Usage\Application\CompleteById\CompleteByIdUsageCommandMother;

final class CompleteByIdUsageCommandHandlerTest extends UsageModuleUnitTestCase
{
    private CompleteByIdUsageCommandHandler|null $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new CompleteByIdUsageCommandHandler(new UsageCompleter(
            $this->repository(),
            $this->createMock(EventBus::class)
        ));
    }

    /** @test */
    public function it_should_complete_a_valid_usage(): void
    {
        $usage     = UsageMother::createIncompleteUsage();
        $command   = CompleteByIdUsageCommandMother::create($usage->id(), $usage->flowVolume(), $usage->closedAt());

        $this->shouldSearch($usage);
        $this->dispatch($command, $this->handler);
    }

    /** @test */
    public function it_should_complete_an_exception_usage_not_exist(): void
    {
        $this->expectException(UsageNotExistException::class);

        $usage     = UsageMother::createIncompleteUsage();
        $command   = CompleteByIdUsageCommandMother::create($usage->id(), $usage->flowVolume(), $usage->closedAt());

        $this->dispatch($command, $this->handler);
    }

    /** @test */
    public function it_should_complete_an_exception_usage_already_complete(): void
    {
        $this->expectException(UsageAlreadyClosedException::class);

        $usage     = UsageMother::create();
        $command   = CompleteByIdUsageCommandMother::create($usage->id(), $usage->flowVolume(), $usage->closedAt());

        $this->shouldSearch($usage);
        $this->dispatch($command, $this->handler);
    }
}
