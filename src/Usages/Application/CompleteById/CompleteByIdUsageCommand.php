<?php

declare(strict_types=1);

namespace App\Usages\Application\CompleteById;

use App\Shared\Domain\Bus\Command\Command;

final class CompleteByIdUsageCommand implements Command
{
    public function __construct(
        private readonly string $id,
        private readonly float $dispenserFlowVolume,
        private readonly string $closedAt
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }
    public function dispenserFlowVolume(): float
    {
        return $this->dispenserFlowVolume;
    }
    public function closedAt(): string
    {
        return $this->closedAt;
    }
}
