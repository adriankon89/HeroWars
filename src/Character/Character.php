<?php

declare(strict_types=1);

namespace App\Character;

class Character
{
    private const SPECIAL_ATTACK_CHANCE_RATE = 70;
    private const FULL_BLOCK_VALUE = 100;

    public int $health = 0;
    public int $damage = 0;
    public int $baseArmor;
    public array $specialAttacks = [];
    public array $specialArmors = [];
    private int $level = 1;
    private int $xp = 0;
    private string $name;

    //Armor w procentach attack - armor
    //baseArmor blockattack

    //był jakis wzorzec z zzaduzą ilością argumentów
    public function __construct(int $health, int $damage, int $baseArmor, array $specialAttacks, array $specialArmors, string $name)
    {
        $this->health = $health;
        $this->damage = $damage;
        $this->baseArmor = $baseArmor;
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
        $chanceToBlock = floor(self::FULL_BLOCK_VALUE / ($this->baseArmor ?: 1));
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
        $specialArmorReduction = 0;
        if ($this->specialArmors) {
            $specialArmor = $this->specialArmors[array_rand($this->specialArmors)];
            $specialArmorReduction =  $specialArmor->getArmorReduction();
        }

        $armor = $this->baseArmor + $specialArmorReduction;
        $attackValue = floor($attackValue * ($armor / self::FULL_BLOCK_VALUE));
        $this->health -= $attackValue;

        return $attackValue;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function addXp(int $xpEarned): int
    {
        $this->xp += $xpEarned;
        return $this->xp;
    }

    public function __toString()
    {
        return "name: {$this->name} health: {$this->health}, damage: {$this->damage}";
    }
}
