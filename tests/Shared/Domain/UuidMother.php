<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain;

use App\Tests\Shared\Domain\MotherCreator;

final class UuidMother
{
    public static function create(): string
    {
        return MotherCreator::random()->unique()->uuid;
    }
}
