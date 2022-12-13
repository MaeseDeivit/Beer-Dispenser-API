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
        $a = DispenserFlowVolumeMother::create()->value();
        $dispenserRequestBody = [
            'dispenserId'      => DispenserId::random()->value(),
            'flowVolume'       => 5
        ];
        $this->client->request('POST', '/api/dispensers', $dispenserRequestBody);
        $this->assertResponseIsSuccessful();
    }
}
