<?php

declare(strict_types=1);

namespace App\Tests\Unit\Health\Application\Service;

use PHPUnit\Framework\TestCase;
use App\Health\Application\CheckHealth\HealthChecker;
use App\Health\Application\CheckHealth\CheckHealthQuery;
use App\Health\Domain\Repository\HealthRepositoryInterface;
use App\Health\Domain\Exceptions\DatabaseNotHealthyRepositoryException;

class GetHealthHandlerTest extends TestCase
{
    private HealthChecker $checker;

    private HealthRepositoryInterface $healthRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->healthRepository = $this->createMock(HealthRepositoryInterface::class);
        $this->checker = new HealthChecker($this->healthRepository);
    }

    public function testReturnGetHealthResponseOk(): void
    {
        $handlerResponse = $this->checker->__invoke(new CheckHealthQuery());

        $this->assertEquals(1, $handlerResponse->getStatus());
    }

    public function testReturnGetHealthResponseFailIfRepositoryFails(): void
    {
        $this->healthRepository
            ->method('health')
            ->will($this->throwException(new DatabaseNotHealthyRepositoryException()));
        $handlerResponse = $this->checker->__invoke(new CheckHealthQuery());

        $this->assertEquals(-1, $handlerResponse->getStatus());
    }
}
