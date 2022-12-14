<?php

declare(strict_types=1);

namespace App\Dispensers\Application\Create;

use App\Shared\Domain\Bus\Command\Command;

final class CreateDispenserCommand implements Command
{
    public function __construct(
        private readonly string $id,
        private readonly float $flowVolume
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }
    public function flowVolume(): float
    {
        return $this->flowVolume;
    }
}
