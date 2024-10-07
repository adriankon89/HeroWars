<?php

declare(strict_types=1);

namespace App;

class GameResult
{
    private int $rounds = 0;

    public function addRound(): void
    {
        $this->rounds++;
    }

    public function getRounds(): int
    {
        return $this->rounds;
    }
}
