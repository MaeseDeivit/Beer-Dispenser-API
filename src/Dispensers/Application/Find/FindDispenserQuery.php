<?php

declare(strict_types=1);

namespace App\Dispensers\Application\Find;

use App\Shared\Domain\Bus\Query\Query;


final class FindDispenserQuery implements Query
{

    public function __construct(private readonly string $id)
    {
    }

    public function id(): string
    {
        return $this->id;
    }
}
