<?php

declare(strict_types=1);

namespace App\Dispensers\Application\Close;

use App\Shared\Domain\Bus\Command\Command;

final class CloseDispenserCommand implements Command
{
    public function __construct(
        private readonly string $id
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }
}
