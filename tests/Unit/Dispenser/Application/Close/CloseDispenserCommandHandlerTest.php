<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dispenser\Application\Close;

use App\Shared\Domain\Bus\Event\EventBus;
use App\Dispensers\Application\Open\DispenserOpener;
use App\Tests\Unit\Dispenser\Domain\DispenserMother;
use App\Dispensers\Application\Close\DispenserCloser;
use App\Dispensers\Application\Create\DispenserCreator;
use App\Tests\Unit\Dispenser\DispenserModuleUnitTestCase;
use App\Dispensers\Application\Open\OpenDispenserCommandHandler;
use App\Dispensers\Domain\Exceptions\DispenserNotExistException;
use App\Dispensers\Application\Close\CloseDispenserCommandHandler;
use App\Dispensers\Application\Create\CreateDispenserCommandHandler;
use App\Dispensers\Domain\Exceptions\DispenserNotGotUsagesException;
use App\Dispensers\Domain\Exceptions\DispenserAlreadyClosedException;
use App\Shared\Domain\Uuid\UsageId;
use App\Tests\Unit\Dispenser\Application\Open\OpenDispenserCommandMother;
use App\Tests\Unit\Dispenser\Application\Close\CloseDispenserCommandMother;
use App\Tests\Unit\Dispenser\Application\Create\CreateDispenserCommandMother;
use App\Tests\Unit\Usage\Domain\UsageMother;
use DateTime;

final class CloseDispenserCommandHandlerTest extends DispenserModuleUnitTestCase
{
    private CloseDispenserCommandHandler|null $handler;
    private OpenDispenserCommandHandler|null $openHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new CloseDispenserCommandHandler(new DispenserCloser(
            $this->repository(),
            $this->repositoryUsage(),
            $this->createMock(EventBus::class)
        ));

        $this->openHandler = new OpenDispenserCommandHandler(new DispenserOpener(
            $this->repository(),
            $this->repositoryUsage(),
            $this->createMock(EventBus::class)
        ));
    }

    /** @test */
    public function it_should_return_an_exception_dispenser_not_exist(): void
    {
        $this->expectException(DispenserNotExistException::class);

        $dispenser = DispenserMother::create();
        $command   = CloseDispenserCommandMother::create($dispenser->id());

        $this->dispatch($command, $this->handler);
    }
    /** @test */
    public function it_should_return_an_exception_dispenser_has_not_usages(): void
    {
        $this->expectException(DispenserNotGotUsagesException::class);

        $dispenser = DispenserMother::create();
        $command   = CloseDispenserCommandMother::create($dispenser->id());

        $dispenser->changeStatusOpen(new DateTime('now'));

        $this->shouldFind($dispenser->id(), $dispenser);

        $this->dispatch($command, $this->handler);
    }
}
