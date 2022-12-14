<?php

declare(strict_types=1);

namespace App\Usages\Application\GetByDispenserId;

use App\Shared\Domain\Bus\Query\Query;


final class FindByDispenserIdUsagesQuery implements Query
{

    public function __construct(private readonly string $dispenserId)
    {
    }

    public function dispenserId(): string
    {
        return $this->dispenserId;
    }
}
