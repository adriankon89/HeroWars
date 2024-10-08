<?php

declare(strict_types=1);

namespace App\ArmorType;

use App\ArmorType\IArmorType;
use App\Dice;

class MediumArmor implements IArmorType
{
    public const MEDIUM_ARMOR_RATE = 20;
    public function getArmorReduction(): int
    {
        return Dice::roll(self::MEDIUM_ARMOR_RATE) + Dice::roll(self::MEDIUM_ARMOR_RATE) + Dice::roll(self::MEDIUM_ARMOR_RATE);
    }
}
