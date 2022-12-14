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
        $this->client->jsonRequest('POST', '/api/dispensers', $dispenserRequestBody);
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());

        $dispenserChangeStatusOpenRequestBody = [
            'status'      => DispenserStatus::OPEN
        ];
        $this->client->jsonRequest('PUT', '/api/dispensers/' . $dispenserId . '/status', $dispenserChangeStatusOpenRequestBody);
        $this->assertEquals(202, $this->client->getResponse()->getStatusCode());
    }

    public function test_create_new_dispenser_and_change_status_to_open_and_close(): void
    {
        $dispenserId = DispenserId::random()->value();
        $dispenserRequestBody = [
            'dispenserId'      => $dispenserId,
            'flowVolume'       => DispenserFlowVolumeMother::create()->value()
        ];
        $this->client->jsonRequest('POST', '/api/dispensers', $dispenserRequestBody);
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());

        $dispenserChangeStatusOpenRequestBody = [
            'status'      => DispenserStatus::OPEN
        ];
        $this->client->jsonRequest('PUT', '/api/dispensers/' . $dispenserId . '/status', $dispenserChangeStatusOpenRequestBody);
        $this->assertEquals(202, $this->client->getResponse()->getStatusCode());

        $dispenserChangeStatusCloseRequestBody = [
            'status'      => DispenserStatus::CLOSE
        ];
        $this->client->jsonRequest('PUT', '/api/dispensers/' . $dispenserId . '/status', $dispenserChangeStatusCloseRequestBody);
        $this->assertEquals(202, $this->client->getResponse()->getStatusCode());
    }

    public function test_exception_open_a_dispenser_not_exist_not_found(): void
    {
        $dispenserChangeStatusOpenRequestBody = [
            'status'      => DispenserStatus::OPEN
        ];
        $this->client->jsonRequest('PUT', '/api/dispensers/' . DispenserId::random()->value() . '/status', $dispenserChangeStatusOpenRequestBody);
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function test_exception_close_a_dispenser_not_exist_not_found(): void
    {
        $dispenserChangeStatusCloseRequestBody = [
            'status'      => DispenserStatus::CLOSE
        ];
        $this->client->jsonRequest('PUT', '/api/dispensers/' . DispenserId::random()->value() . '/status', $dispenserChangeStatusCloseRequestBody);
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }
    public function test_exception_dispenser_already_opened_conflict(): void
    {
        $dispenserId = DispenserId::random()->value();
        $dispenserRequestBody = [
            'dispenserId'      => $dispenserId,
            'flowVolume'       => DispenserFlowVolumeMother::create()->value()
        ];
        $this->client->jsonRequest('POST', '/api/dispensers', $dispenserRequestBody);
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());

        $dispenserChangeStatusOpenRequestBody = [
            'status'      => DispenserStatus::OPEN
        ];
        $this->client->jsonRequest('PUT', '/api/dispensers/' . $dispenserId . '/status', $dispenserChangeStatusOpenRequestBody);
        $this->assertEquals(202, $this->client->getResponse()->getStatusCode());

        $this->client->jsonRequest('PUT', '/api/dispensers/' . $dispenserId . '/status', $dispenserChangeStatusOpenRequestBody);
        $this->assertEquals(409, $this->client->getResponse()->getStatusCode());
    }

    public function test_exception_dispenser_already_closed_conflict(): void
    {
        $dispenserId = DispenserId::random()->value();
        $dispenserRequestBody = [
            'dispenserId'      => $dispenserId,
            'flowVolume'       => DispenserFlowVolumeMother::create()->value()
        ];
        $this->client->jsonRequest('POST', '/api/dispensers', $dispenserRequestBody);
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());

        $dispenserChangeStatusCloseRequestBody = [
            'status'      => DispenserStatus::CLOSE
        ];
        $this->client->jsonRequest('PUT', '/api/dispensers/' . $dispenserId . '/status', $dispenserChangeStatusCloseRequestBody);
        $this->assertEquals(409, $this->client->getResponse()->getStatusCode());
    }
}
