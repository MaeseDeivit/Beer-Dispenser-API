<?php

declare(strict_types=1);

namespace App\Dispensers\Application\Open;

use App\Shared\Domain\Bus\Command\Command;

final class OpenDispenserCommand implements Command
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
