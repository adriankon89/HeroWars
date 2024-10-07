<?php

declare(strict_types=1);

namespace App\SpecialAttacks;

interface Attack
{
    public function damage(int $baseDamage): int;
}
