<?php

declare(strict_types=1);

namespace App\Builder;

use App\ArmorType\IArmorType;
use App\ArmorType\LightArmor;
use App\ArmorType\MediumArmor;
use App\Character\Hero;
use App\SpecialAttacks\Attack;
use Psr\Log\LoggerInterface;

class CharacterBuilder implements CharacterBuilderInterface
{
    private int $maxHealth;
    private int $armorRating;
    private int $damage;
    /** @var Attack[] $specialAttacks Array of special attacks. */
    private array $specialAttacks;
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

    public function setArmor(int $armorRating): self
    {
        $this->armorRating = $armorRating;
        return $this;
    }

    /**
     * @param Attack[] $attacks
     */
    public function setSpecialAttacks(array $attackTypes): self
    {
        $this->specialAttacks = $attackTypes;
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

    public function build(): Hero
    {
        $this->logger->info('Creating a character!', [
            'maxHealth' => $this->maxHealth,
            'baseDamage' => $this->damage,
        ]);

        return new Hero(
            $this->maxHealth,
            $this->damage,
            $this->armorRating,
            $this->specialAttacks,
            [$this->createSpecialArmor()],
            $this->name
        );
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
