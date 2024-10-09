<?php

declare(strict_types=1);

namespace App\Builder;

use App\Character\Hero;

interface CharacterBuilderInterface
{
    public function setName(string $name): self;
    public function setMaxHealth(int $health): self;
    public function setDamage(int $damage): self;
    public function setArmor(int $armor): self;
    public function setSpecialAttacks(array $attackTypes): self;
    public function setArmorType(string $armorType): self;
    public function build(): Hero;
}
