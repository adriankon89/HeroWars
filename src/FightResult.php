<?php

declare(strict_types=1);

namespace App;

use App\Character\Hero;

class FightResult
{
    private Hero $winner;
    private Hero $loser;
    private int $rounds = 0;
    private int $damageDealt = 0;
    private int $damageReceived = 0;
    private int $exhaustedTurns = 0;

    public function getWinner(): Hero
    {
        return $this->winner;
    }

    public function setWinner(Hero $winner): void
    {
        $this->winner = $winner;
    }

    public function getLoser(): Hero
    {
        return $this->loser;
    }

    public function setLoser(Hero $loser): void
    {
        $this->loser = $loser;
    }

    public function getRounds(): int
    {
        return $this->rounds;
    }

    public function addRound(): void
    {
        $this->rounds++;
    }

    public function getDamageDealt(): int
    {
        return $this->damageDealt;
    }

    public function addDamageDealt(int $damageDealt): void
    {
        $this->damageDealt += $damageDealt;
    }

    public function getDamageReceived(): int
    {
        return $this->damageReceived;
    }

    public function addDamageReceived(int $damageReceived): void
    {
        $this->damageReceived += $damageReceived;
    }

    public function addExhaustedTurn(): void
    {
        $this->exhaustedTurns++;
    }

    public function getExhaustedTurns(): int
    {
        return $this->exhaustedTurns;
    }
}
