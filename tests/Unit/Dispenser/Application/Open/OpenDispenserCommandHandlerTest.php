<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dispenser\Application\Open;

use DateTime;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Dispensers\Application\Open\DispenserOpener;
use App\Tests\Unit\Dispenser\Domain\DispenserMother;
use App\Tests\Unit\Dispenser\DispenserModuleUnitTestCase;
use App\Dispensers\Application\Open\OpenDispenserCommandHandler;
use App\Dispensers\Domain\Exceptions\DispenserNotExistException;
use App\Dispensers\Domain\Exceptions\DispenserAlreadyOpenedException;
use App\Tests\Unit\Dispenser\Application\Open\OpenDispenserCommandMother;

final class OpenDispenserCommandHandlerTest extends DispenserModuleUnitTestCase
{
    private OpenDispenserCommandHandler|null $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new OpenDispenserCommandHandler(new DispenserOpener(
            $this->repository(),
            $this->repositoryUsage(),
            $this->createMock(EventBus::class)
        ));
    }

    /** @test */
    public function it_should_open_a_valid_dispenser(): void
    {
        $dispenser = DispenserMother::create();
        $command   = OpenDispenserCommandMother::create($dispenser->id());

        $dispenser->changeStatusClose(new DateTime('now'));

        $this->shouldFind($dispenser->id(), $dispenser);

        $this->handler->__invoke($command);
    }

    /** @test */
    public function it_should_return_an_exception_dispenser_already_opened(): void
    {
        $this->expectException(DispenserAlreadyOpenedException::class);

        $dispenser = DispenserMother::create();
        $command   = OpenDispenserCommandMother::create($dispenser->id());
        $this->shouldSearch($dispenser);

        $this->handler->__invoke($command);
        $this->handler->__invoke($command);
    }

    /** @test */
    public function it_should_return_an_exception_dispenser_not_exist(): void
    {
        $this->expectException(DispenserNotExistException::class);

        $dispenser = DispenserMother::create();
        $command   = OpenDispenserCommandMother::create($dispenser->id());

        $this->handler->__invoke($command);
    }
}
