<?php

declare(strict_types=1);

namespace App\Shared\Domain\Bus\Event;

interface DomainEventSubscriber
{
    public function subscribedTo(): array;
}
