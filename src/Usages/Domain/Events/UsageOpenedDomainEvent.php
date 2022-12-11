<?php

declare(strict_types=1);

namespace App\Usages\Domain\Events;

use App\Shared\Domain\Bus\Event\DomainEvent;

final class UsageOpenedDomainEvent extends DomainEvent
{
    public function __construct(
        string $id,
        private readonly string $dispenserId,
        private readonly string $openedAt,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'usage.opened';
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
            $body['openedAt'],
            $eventId,
            $occurredOn
        );
    }

    public function toPrimitives(): array
    {
        return [
            'dispenserId' => $this->dispenserId,
            'openedAt'    => $this->openedAt
        ];
    }

    public function dispenserId(): string
    {
        return $this->dispenserId;
    }

    public function openedAt(): string
    {
        return $this->openedAt;
    }
}
