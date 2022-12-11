<?php

declare(strict_types=1);

namespace App\Dispensers\Application;

use App\Shared\Domain\Bus\Query\Response;
use App\Dispensers\Application\DispenserResponse;

final class DispensersResponse implements Response
{
    private array $dispensers;

    public function __construct(DispenserResponse ...$dispensers)
    {
        $this->dispensers = $dispensers;
    }

    public function dispensers(): array
    {
        return $this->dispensers;
    }
}
