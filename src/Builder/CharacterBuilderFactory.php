<?php

declare(strict_types=1);

namespace App\Builder;

use App\Builder\CharacterBuilder;
use App\Character\Character;
use App\SpecialAttacks\FireAttack;
use App\SpecialAttacks\IceAttack;
use App\SpecialAttacks\PoisonAttack;
use Psr\Log\LoggerInterface;
use RuntimeException;

class CharacterBuilderFactory
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function createBuilder(): CharacterBuilder
    {
        return new CharacterBuilder($this->logger);
    }

    public function getArcher(): CharacterBuilder
    {
        return $this->createBuilder()
            ->setMaxHealth(100)
            ->setDamage(5)
            ->setArmor(1)
            ->setSpecialAttacks([new FireAttack()])
            ->setArmorType('lightArmor');
    }

    public function getKnight(): CharacterBuilder
    {
        return $this->createBuilder()
            ->setMaxHealth(120)
            ->setDamage(8)
            ->setArmor(3)
            ->setSpecialAttacks([new PoisonAttack()])
            ->setArmorType('heavyArmor');
    }

    public function getGoblin(): CharacterBuilder
    {
        return $this->createBuilder()
            ->setMaxHealth(80)
            ->setDamage(6)
            ->setArmor(2)
            ->setSpecialAttacks([new IceAttack()])
            ->setArmorType('lightArmor');
    }

    public function createCharacter(string $characterType, string $playerName): Character
    {
        return match (strtolower($characterType)) {
            'archer' => $this->getArcher()->setName($playerName)->build(),
            'knight' => $this->getKnight()->setName($playerName)->build(),
            'goblin' => $this->getGoblin()->setName($playerName)->build(),
            default => throw new RuntimeException('Undefined character'),
        };
    }
}
