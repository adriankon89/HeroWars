<?php

declare(strict_types=1);

namespace App\Enum;

enum CharacterTypes: string
{
    case Archer = 'archer';
    case Knight = 'knight';
    case Goblin = 'goblin';
}
