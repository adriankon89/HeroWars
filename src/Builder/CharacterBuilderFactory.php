<?php

declare(strict_types=1);

namespace App\Builder;

use App\Builder\CharacterBuilder;
use App\Character\Character;
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

    public function createCharacter(string $characterType, string $playerName): Character
    {
        return match(strtolower($characterType)) {
            'archer' => $this->createBuilder()
                        ->setMaxHealth(100)
                        ->setDamage(5)
                        ->setArmor(1)
                        ->setAttackType('fire')
                        ->setArmorType('lightArmor')
                        ->setName($playerName)
                        ->buildCharacter(),
            'knight' => $this->createBuilder()
                        ->setMaxHealth(100)
                        ->setDamage(5)
                        ->setArmor(1)
                        ->setAttackType('fire')
                        ->setArmorType('mediumArmor')
                        ->setName($playerName)
                        ->buildCharacter(),
            'goblin' => $this->createBuilder()
                        ->setMaxHealth(100)
                        ->setDamage(5)
                        ->setArmor(1)
                        ->setName($playerName)
                        ->setAttackType('fire')
                        ->setArmorType('lightArmor')
                        ->buildCharacter(),
            default => throw new RuntimeException('Undefined character')
        };
    }
}
