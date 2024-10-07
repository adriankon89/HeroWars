<?php

namespace App\SpecialAttacks;

use App\Dice;

class FireAttack implements Attack
{
    public function damage(int $baseDamage): int
    {
        return 15;

        $criticalChance = Dice::roll(100);
        return $criticalChance > 70 ? $baseDamage * 3 : $baseDamage;
    }

}
