<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usage\Application\GetByDispenserId;

use App\Shared\Domain\Uuid\DispenserId;
use App\Tests\Unit\Usage\Application\UsageModuleUnitTestCase;
use App\Usages\Application\GetByDispenserId\UsagesByDispenserIdFinder;
use App\Usages\Application\GetByDispenserId\FindByDispenserIdUsagesQuery;
use App\Usages\Application\GetByDispenserId\FindByDispenserIdUsagesQueryHandler;

final class FindByDispenserIdUsagesQueryHandlerTest extends UsageModuleUnitTestCase
{
    private FindByDispenserIdUsagesQueryHandler|null $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new FindByDispenserIdUsagesQueryHandler(
            new UsagesByDispenserIdFinder(
                $this->repository()
            )
        );
    }

    /** @test */
    public function it_should_find_all_usages_of_a_dispenser(): void
    {

        $dispenserId  = DispenserId::random();
        $query      = new FindByDispenserIdUsagesQuery($dispenserId->value());

        $this->shouldSearchByDispenserId($dispenserId);
        $this->assertEquals([], $this->handler->__invoke($query));
    }
}
