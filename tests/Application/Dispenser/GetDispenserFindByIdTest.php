<?php

declare(strict_types=1);

namespace App\Tests\Application\Dispenser;

use App\Shared\Domain\Uuid\DispenserId;
use App\Tests\Unit\Dispenser\Domain\DispenserFlowVolumeMother;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetDispenserFindByIdTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        self::ensureKernelShutdown();
        $this->client = static::createClient();
    }

    public function test_create_new_dispenser_and_find_it_with_spending(): void
    {
        $dispenserId = DispenserId::random()->value();
        $dispenserRequestBody = [
            'dispenserId'      => $dispenserId,
            'flowVolume'       => DispenserFlowVolumeMother::create()->value()
        ];
        $this->client->jsonRequest('POST', '/api/dispensers', $dispenserRequestBody);
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', '/api/dispensers/' . $dispenserId . '/spending');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function test_dispenser_not_exist_exception_not_found(): void
    {
        $dispenserId = DispenserId::random()->value();

        $this->client->request('GET', '/api/dispensers/' . $dispenserId . '/spending');
       
        $this->assertEquals(500, $this->client->getResponse()->getStatusCode());
        $this->assertStringContainsString('9999',$this->client->getResponse()->getContent());
    }
}
