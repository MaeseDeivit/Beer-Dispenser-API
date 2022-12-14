<?php

declare(strict_types=1);

namespace App\Usages\Application;

use App\Shared\Domain\Bus\Query\Response;

final class UsageResponse implements Response
{
    public function __construct(
        private string $id,
        private ?float $flowVolume,
        private ?float $totalSpent,
        private string $openedAt,
        private ?string $closedAt
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }
    public function flowVolume(): ?float
    {
        return $this->flowVolume;
    }

    public function totalSpent(): ?float
    {
        return $this->totalSpent;
    }

    public function openedAt(): string
    {
        return $this->openedAt;
    }
    public function closedAt(): ?string
    {
        return $this->closedAt;
    }
    public function values(): array
    {
        return [
            'flow_volume'                    => $this->flowVolume(),
            'total_spent'                    => $this->totalSpent(),
            'opened_at'                      => $this->openedAt(),
            'closed_at'                      => $this->closedAt()
        ];
    }
}
