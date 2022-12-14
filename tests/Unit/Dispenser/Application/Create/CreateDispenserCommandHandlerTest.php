<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dispenser\Application\Create;

use App\Shared\Domain\Bus\Event\EventBus;
use App\Tests\Unit\Dispenser\Domain\DispenserMother;
use App\Dispensers\Application\Create\DispenserCreator;
use App\Tests\Unit\Dispenser\DispenserModuleUnitTestCase;
use App\Dispensers\Application\Create\CreateDispenserCommandHandler;
use App\Tests\Unit\Dispenser\Application\Create\CreateDispenserCommandMother;

final class CreateDispenserCommandHandlerTest extends DispenserModuleUnitTestCase
{
    private CreateDispenserCommandHandler|null $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new CreateDispenserCommandHandler(new DispenserCreator(
            $this->repository(),
            $this->createMock(EventBus::class)
        ));
    }

    /** @test */
    public function it_should_create_a_valid_dispenser(): void
    {
        $dispenser = DispenserMother::create();
        $command   = CreateDispenserCommandMother::create($dispenser->id(), $dispenser->flowVolume());

        $this->shouldSave($dispenser);
        $this->dispatch($command, $this->handler);
    }
}
