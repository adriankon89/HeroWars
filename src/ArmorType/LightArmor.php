<?php

declare(strict_types=1);

namespace App\ArmorType;

use App\ArmorType\IArmorType;
use App\Dice;

class LightArmor implements IArmorType
{
    public function getArmorReduction(): int
    {
        return Dice::roll(10) + Dice::roll(10) + Dice::roll(10);
    }
}
