<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain;

use App\Tests\Shared\Domain\MotherCreator;

final class FloatMother
{
    public static function create(): float
    {
        return self::between(0.001);
    }

    public static function between(float $min, $max = PHP_INT_MAX): float
    {
        return MotherCreator::random()->numberBetween($min, $max);
    }

    public static function lessThan(float $max): float
    {
        return self::between(0.001, $max);
    }
}
