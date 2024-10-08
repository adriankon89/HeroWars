<?php

declare(strict_types=1);

namespace App\Builder;

use App\ArmorType\IArmorType;
use App\ArmorType\LightArmor;
use App\ArmorType\MediumArmor;
use App\Character\Character;
use App\SpecialAttacks\FireAttack;
use App\SpecialAttacks\Attack;
use App\SpecialAttacks\IceAttack;
use App\SpecialAttacks\PoisonAttack;
use Psr\Log\LoggerInterface;

class CharacterBuilder
{
    private int $maxHealth;
    private int $armor;
    private int $damage;
    private array $attackTypes;
    private string $armorType;
    private string $name;

    public function __construct(private LoggerInterface $logger)
    {
    }

    public function setMaxHealth(int $maxHealth): self
    {
        $this->maxHealth = $maxHealth;
        return $this;
    }

    public function setDamage(int $damage): self
    {
        $this->damage = $damage;
        return $this;
    }

    public function setArmor(int $armor): self
    {
        $this->armor = $armor;
        return $this;
    }

    public function setAttackType(string ...$attackTypes): self
    {
        $this->attackTypes = $attackTypes;
        return $this;
    }

    public function setArmorType(string $armorType): self
    {
        $this->armorType = $armorType;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function buildCharacter(): Character
    {
        $attackTypes = array_map(fn (string $attackType) => $this->createAttackType($attackType), $this->attackTypes);
        $this->logger->info('Creating a character!', [
            'maxHealth' => $this->maxHealth,
            'baseDamage' => $this->damage,
        ]);

        return new Character(
            $this->maxHealth,
            $this->damage,
            $this->armor,
            $attackTypes,
            [$this->createSpecialArmor()],
            $this->name
        );
    }

    private function createAttackType(string $attackType): Attack
    {
        return match ($attackType) {
            'fire' => new FireAttack(),
            'ice' => new IceAttack(),
            'poison' => new PoisonAttack(),
            default => throw new \RuntimeException('Invalid attack type given')
        };
    }

    private function createSpecialArmor(): IArmorType
    {
        return match ($this->armorType) {
            'lightArmor' => new LightArmor(),
            'mediumArmor' => new MediumArmor(),
            default => throw new \RuntimeException('Invalid armor type given')
        };
    }
}
