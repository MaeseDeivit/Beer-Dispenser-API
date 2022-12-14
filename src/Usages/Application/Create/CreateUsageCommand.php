<?php

declare(strict_types=1);

namespace App\Usages\Application\Create;

use App\Shared\Domain\Bus\Command\Command;

final class CreateUsageCommand implements Command
{
    public function __construct(
        private readonly string $id,
        private readonly string $dispenserId,
        private readonly string $createdAt
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }
    public function dispenserId(): string
    {
        return $this->dispenserId;
    }
    public function createdAt(): string
    {
        return $this->createdAt;
    }
}
