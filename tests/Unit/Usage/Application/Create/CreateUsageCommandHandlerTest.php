<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usage\Application\Create;

use App\Shared\Domain\Bus\Event\EventBus;
use App\Tests\Unit\Usage\Domain\UsageMother;
use App\Usages\Application\Create\UsageCreator;
use App\Usages\Application\Create\CreateUsageCommandHandler;
use App\Tests\Unit\Usage\Application\UsageModuleUnitTestCase;
use App\Tests\Unit\Usage\Application\Create\CreateUsageCommandMother;

final class CreateUsageCommandHandlerTest extends UsageModuleUnitTestCase
{
    private CreateUsageCommandHandler|null $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new CreateUsageCommandHandler(new UsageCreator(
            $this->repository(),
            $this->createMock(EventBus::class)
        ));
    }

    /** @test */
    public function it_should_create_a_valid_usage(): void
    {
        $usage = UsageMother::create();
        $command   = CreateUsageCommandMother::create($usage->id(), $usage->dispenserId(), $usage->openedAt());

        $this->shouldSave($usage);
        $this->dispatch($command, $this->handler);
    }
}
