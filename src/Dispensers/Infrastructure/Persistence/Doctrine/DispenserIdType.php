<?php

declare(strict_types=1);

namespace App\Dispensers\Infrastructure\Persistence\Doctrine;

use App\Shared\Domain\Uuid\DispenserId;
use App\Shared\Infrastructure\Persistence\Doctrine\UuidType;


final class DispenserIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return DispenserId::class;
    }
}
