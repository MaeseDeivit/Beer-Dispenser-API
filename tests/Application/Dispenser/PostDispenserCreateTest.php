<?php

declare(strict_types=1);

namespace App\Tests\Application\Dispenser;

use App\Shared\Domain\Uuid\DispenserId;
use App\Tests\Unit\Dispenser\Domain\DispenserFlowVolumeMother;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostDispenserCreateTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        self::ensureKernelShutdown();
        $this->client = static::createClient();
    }

    public function test_create_new_dispenser(): void
    {
        $dispenserRequestBody = [
            'dispenserId'      => DispenserId::random()->value(),
            'flowVolume'       => DispenserFlowVolumeMother::create()->value()
        ];
        $this->client->jsonRequest('POST', '/api/dispensers', $dispenserRequestBody);
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }
    public function test_create_new_dispenser_exception_invalid_format_bad_request(): void
    {
        $dispenserRequestBody = [
            'dispenserId'      => DispenserId::random()->value() . DispenserId::random()->value(),
            'flowVolume'       => null
        ];
        $this->client->jsonRequest('POST', '/api/dispensers', $dispenserRequestBody);
        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
    }

    public function test_create_new_dispenser_exception_already_exist_conflict(): void
    {
        $dispenserRequestBody = [
            'dispenserId'      => DispenserId::random()->value(),
            'flowVolume'       => DispenserFlowVolumeMother::create()->value()
        ];
        $this->client->jsonRequest('POST', '/api/dispensers', $dispenserRequestBody);
        $this->client->jsonRequest('POST', '/api/dispensers', $dispenserRequestBody);
        $this->assertEquals(409, $this->client->getResponse()->getStatusCode());
    }
}
