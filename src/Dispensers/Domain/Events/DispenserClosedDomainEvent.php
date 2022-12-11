<?php

declare(strict_types=1);

namespace App\Dispensers\Domain\Events;

use App\Dispensers\Domain\Model\DispenserStatus;
use App\Shared\Domain\Bus\Event\DomainEvent;

final class DispenserClosedDomainEvent extends DomainEvent
{
    private $status = DispenserStatus::CLOSE;

    public function __construct(
        string $id,
        private readonly string $createdOn,
        private readonly string $updatedOn,
        string $eventId = null,
        string $occurredOn = null
    ) {

        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'dispenser.closed';
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self(
            $aggregateId,
            $body['status'],
            $body['createdOn'],
            $body['updatedOn'],
            $eventId,
            $occurredOn
        );
    }

    public function toPrimitives(): array
    {
        return [
            'status'     => $this->status,
            'createdOn'  => $this->createdOn,
            'updatedOn'  => $this->updatedOn
        ];
    }

    public function status(): string
    {
        return $this->status;
    }
    public function createdOn(): string
    {
        return $this->createdOn;
    }
    public function updatedOn(): string
    {
        return $this->updatedOn;
    }
}
