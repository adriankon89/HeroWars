<?php

declare(strict_types=1);

namespace App\SpecialAttacks;

class IceAttack implements Attack
{
    public function damage(int $baseDamage): int
    {
        return 15;
    }
}
