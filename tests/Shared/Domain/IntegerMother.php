<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain;

use App\Tests\Shared\Domain\MotherCreator;


final class IntegerMother
{
    public static function create(): int
    {
        return self::between(1);
    }

    public static function between(int $min, $max = PHP_INT_MAX): int
    {
        return MotherCreator::random()->numberBetween($min, $max);
    }

    public static function lessThan(int $max): int
    {
        return self::between(1, $max);
    }
}
