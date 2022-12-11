<?php

declare(strict_types=1);

namespace App\Usages\Domain\Events;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class UsageCompletedDomainEvent extends DomainEvent
{
    public function __construct(
        string $id,
        private readonly string $dispenserId,
        private readonly float  $totalSpent,
        private readonly string $openedAt,
        private readonly string $closedAt,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'usage.completed';
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self(
            $aggregateId,
            $body['dispenserId'],
            $body['totalSpent'],
            $body['openedAt'],
            $body['closedAt'],
            $eventId,
            $occurredOn
        );
    }

    public function toPrimitives(): array
    {
        return [
            'dispenserId' => $this->dispenserId,
            'totalSpent'  => $this->totalSpent,
            'openedAt'    => $this->openedAt,
            'closedAt'    => $this->closedAt
        ];
    }

    public function dispenserId(): string
    {
        return $this->dispenserId;
    }

    public function totalSpent(): float
    {
        return $this->totalSpent;
    }
    public function openedAt(): string
    {
        return $this->openedAt;
    }
    public function closedAt(): string
    {
        return $this->closedAt;
    }
}
