<?php

declare(strict_types=1);

namespace App\Dispensers\Domain\Events;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class DispenserCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string $id,
        private readonly float $flowVolume,
        private readonly string $status,
        private readonly string $createdOn,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'dispenser.created';
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self(
            $aggregateId,
            $body['flowVolume'],
            $body['status'],
            $body['createdOn'],
            $eventId,
            $occurredOn
        );
    }

    public function toPrimitives(): array
    {
        return [
            'flowVolume' => $this->flowVolume,
            'status'     => $this->status,
            'createdOn'  => $this->createdOn,
        ];
    }

    public function flowVolume(): float
    {
        return $this->flowVolume;
    }

    public function status(): string
    {
        return $this->status;
    }
    public function createdOn(): string
    {
        return $this->createdOn;
    }
}
