<?php

declare(strict_types=1);

namespace App\ArmorType;

use App\ArmorType\IArmorType;
use App\Dice;

class LightArmor implements IArmorType
{
    public const LIGHT_ARMOR_RATE = 10;
    public function getArmorReduction(): int
    {
        return Dice::roll(self::LIGHT_ARMOR_RATE) + Dice::roll(self::LIGHT_ARMOR_RATE) + Dice::roll(self::LIGHT_ARMOR_RATE);
    }
}
