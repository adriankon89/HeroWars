<?php

declare(strict_types=1);

namespace App;

class Dice
{
    public static function specialAttackRoll(): bool
    {
        return rand(1, 6) === 1;
    }

    public static function roll(int $sides): int
    {
        return random_int(1, $sides);
    }
}
