<?php

declare(strict_types=1);

namespace App\Character;

use App\Dice;

class Hero
{
    private const SPECIAL_ATTACK_CHANCE_RATE = 70;
    private const FULL_BLOCK_VALUE = 100;

    public int $health = 0;
    public int $damage = 0;
    public int $armorRating = 1;
    public array $specialAttacks = [];
    public array $specialArmors = [];
    private string $name;

    //Armor w procentach attack - armor
    //armorRating blockattack

    //był jakis wzorzec z zzaduzą ilością argumentów
    public function __construct(int $health, int $damage, int $armorRating, array $specialAttacks, array $specialArmors, string $name)
    {
        $this->health = $health;
        $this->damage = $damage;
        $this->armorRating = $armorRating;
        $this->specialAttacks = $specialAttacks;
        $this->specialArmors = $specialArmors;
        $this->name = $name;
    }

    public function isDead(): bool
    {
        return $this->health <= 0;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    public function getDamage(): int
    {
        return $this->damage;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function blockAttack(): bool
    {
        $chanceToBlock = (int) floor(self::FULL_BLOCK_VALUE / $this->armorRating);
        return rand(1, $chanceToBlock) === rand(1, $chanceToBlock);
    }

    public function getAttackValue(): int
    {
        $attackValue = $this->damage;
        if ($this->specialAttacks && ($specialAttackChance = Dice::roll(100)) && $specialAttackChance > self::SPECIAL_ATTACK_CHANCE_RATE) {
            $specialAttack = $this->specialAttacks[array_rand($this->specialAttacks)];
            $attackValue += $specialAttack->damage($attackValue);
        }

        return $attackValue;
    }

    public function makeDamage(int $attackValue): int
    {
        $percentArmorReduction = $this->calculateArmorReduction() / self::FULL_BLOCK_VALUE;
        $attackValue = (int) floor($attackValue * $percentArmorReduction);
        $this->health -= $attackValue;

        return $attackValue;
    }

    private function calculateArmorReduction(): int
    {
        $specialArmorReduction = 0;
        if ($this->specialArmors) {
            $specialArmor = $this->specialArmors[array_rand($this->specialArmors)];
            $specialArmorReduction =  $specialArmor->getArmorReduction();
        }

        return (int) $this->armorRating + $specialArmorReduction;
    }

    public function __toString()
    {
        return "name: {$this->name} health: {$this->health}, damage: {$this->damage}";
    }
}
