<?php

declare(strict_types=1);

namespace App\Usages\Infrastructure\Persistence\Doctrine;

use App\Shared\Domain\Uuid\UsageId;
use App\Shared\Infrastructure\Persistence\Doctrine\UuidType;


final class UsageIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return UsageId::class;
    }
}
