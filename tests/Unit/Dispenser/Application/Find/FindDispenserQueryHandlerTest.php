<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dispenser\Application\Find;

use App\Dispensers\Application\Find\DispenserFinder;
use App\Tests\Unit\Dispenser\Domain\DispenserMother;
use App\Dispensers\Application\Find\FindDispenserQuery;
use App\Tests\Unit\Dispenser\DispenserModuleUnitTestCase;
use App\Dispensers\Application\Find\FindDispenserQueryHandler;
use App\Dispensers\Domain\Exceptions\DispenserNotExistException;
use App\Shared\Domain\Uuid\DispenserId;
use App\Tests\Unit\Dispenser\Application\Find\DispenserResponseMother;

final class FindDispenserQueryHandlerTest extends DispenserModuleUnitTestCase
{
    private FindDispenserQueryHandler|null $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new FindDispenserQueryHandler(
            new DispenserFinder(
                $this->repository(),
                $this->repositoryUsage()
            )
        );
    }

    /** @test */
    public function it_should_find_an_existing_dispenser(): void
    {

        $dispenser  = DispenserMother::create();
        $query    = new FindDispenserQuery($dispenser->id()->value());
        $response = DispenserResponseMother::create(
            $dispenser->id(),
            $dispenser->flowVolume(),
            $dispenser->totalAmount(),
            $dispenser->status(),
            $dispenser->createdOn(),
            $dispenser->updatedOn(),
            $dispenser->usages()
        );
        $this->shouldFind(new DispenserId($query->id()), $dispenser);
        $this->assertEquals($response, $this->handler->__invoke($query));
    }

    /** @test */
    public function it_should_throw_an_exception_when_dispenser_does_not_exists()
    {
        $query    = new FindDispenserQuery(DispenserId::random()->value());
        $this->assertAskThrowsException(DispenserNotExistException::class, $query, $this->handler);
    }
}
