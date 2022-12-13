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
        $this->client->request('POST', '/api/dispensers', $dispenserRequestBody);
        $this->assertResponseIsSuccessful();

        $this->client->request('Get', '/api/dispensers/' . $dispenserId . '/spending');
        $this->assertResponseIsSuccessful();
    }
}
