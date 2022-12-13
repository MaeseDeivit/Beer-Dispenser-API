<?php

declare(strict_types=1);

namespace App\Tests\Application\Dispenser;

use App\Shared\Domain\Uuid\DispenserId;
use App\Dispensers\Domain\Model\DispenserStatus;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\Unit\Dispenser\Domain\DispenserFlowVolumeMother;

class PutDispenserChangeStatusTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        self::ensureKernelShutdown();
        $this->client = static::createClient();
    }

    public function test_create_new_dispenser_and_change_status_to_open(): void
    {
        $dispenserId = DispenserId::random()->value();
        $dispenserRequestBody = [
            'dispenserId'      => $dispenserId,
            'flowVolume'       => DispenserFlowVolumeMother::create()->value()
        ];
        $this->client->request('POST', '/api/dispensers', $dispenserRequestBody);
        $this->assertResponseIsSuccessful();

        $dispenserChangeStatusOpenRequestBody = [
            'status'      => DispenserStatus::OPEN
        ];
        $this->client->request('PUT', '/api/dispensers/' . $dispenserId . '/status', $dispenserChangeStatusOpenRequestBody);
        $this->assertResponseIsSuccessful();
    }

    public function test_create_new_dispenser_and_change_status_to_open_and_close(): void
    {
        $dispenserId = DispenserId::random()->value();
        $dispenserRequestBody = [
            'dispenserId'      => $dispenserId,
            'flowVolume'       => DispenserFlowVolumeMother::create()->value()
        ];
        $this->client->request('POST', '/api/dispensers', $dispenserRequestBody);
        $this->assertResponseIsSuccessful();

        $dispenserChangeStatusOpenRequestBody = [
            'status'      => DispenserStatus::OPEN
        ];
        $this->client->request('PUT', '/api/dispensers/' . $dispenserId . '/status', $dispenserChangeStatusOpenRequestBody);
        $this->assertResponseIsSuccessful();

        $dispenserChangeStatusOpenRequestBody = [
            'status'      => DispenserStatus::CLOSE
        ];
        $this->client->request('PUT', '/api/dispensers/' . $dispenserId . '/status', $dispenserChangeStatusOpenRequestBody);
        $this->assertResponseIsSuccessful();
    }
}
