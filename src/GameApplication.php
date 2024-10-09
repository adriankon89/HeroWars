<?php

declare(strict_types=1);

namespace App;

use App\Builder\CharacterBuilder;
use App\Character\Hero;
use App\Builder\CharacterBuilderFactory;
use App\Observer\GameObserverInterface;
use App\Enum\CharacterTypes;
use Symfony\Component\Console\Output\OutputInterface;

class GameApplication
{
    private $isPlayerOneTurn = true;
    private array $observers = [];
    private Hero $playerOne;
    private Hero $playerTwo;

    public function __construct(
        private OutputInterface $output,
        private CharacterBuilderFactory $characterBuilderFactory,
        private GameResult $gameResult
    ) {
    }

    public function setPlayerOne(Hero $playerOne)
    {
        $this->playerOne = $playerOne;
    }

    public function setPlayerTwo(Hero $playerTwo)
    {
        $this->playerTwo = $playerTwo;
    }

    public function createCharacter(string $characterType, string $playerName): Hero
    {
        return $this->characterBuilderFactory->createCharacter($characterType, $playerName);
    }

    public function getCharacterList(): array
    {
        $characters = [];
        foreach (CharacterTypes::cases() as $character) {
            $characters[] = $character->value;
        }

        return $characters;
    }

    public function getDefaultCharacterName(): string
    {
        return $this->getCharacterList()[0];
    }

    public function subscribe(GameObserverInterface $observer): void
    {
        if (!in_array($observer, $this->observers, true)) {
            $this->observers[] = $observer;
        }
    }

    public function unsubscribe(GameObserverInterface $observer): void
    {
        $key = array_search($observer, $this->observers, true);
        if ($key !== false) {
            unset($this->observers[$key]);
        }

    }

    public function fight(): bool
    {
        $characters = [$this->playerOne, $this->playerTwo];
        shuffle($characters);
        $playerOne = $characters[0];
        $playerTwo = $characters[1];

        $this->output->writeln($playerOne);
        $this->output->writeln($playerTwo);
        $this->output->writeln('');
        $this->output->writeln('Game start ⚔️');
        while (true) {
            $this->gameResult->addRound();
            $this->output->writeln("Round: {$this->gameResult->getRounds()}");
            $this->playTurn($playerOne, $playerTwo);
            $this->output->writeln($playerOne);
            $this->output->writeln($playerTwo);
            /**
             * get attack value
             * get block value
             * make damage
             */

            if ($playerOne->isDead()) {
                $this->output->writeln($playerOne);
                $this->output->writeln($playerTwo);
                $this->output->writeln('Second Player WIN');
                return true;

            }
            if ($playerTwo->isDead()) {
                $this->output->writeln($playerOne);
                $this->output->writeln($playerTwo);
                $this->output->writeln('First Player WIN');
                return true;
            }



        }

        return true;

    }

    public function playTurn(Hero $playerOne, Hero $playerTwo): void
    {
        if ($this->isPlayerOneTurn) {
            $this->attack($playerOne, $playerTwo);
        } else {
            $this->attack($playerTwo, $playerOne);
        }
        $this->changePlayerTurn();
    }

    public function changePlayerTurn(): void
    {
        $this->isPlayerOneTurn = !$this->isPlayerOneTurn;
    }

    public function attack(Hero $playerWhoAttack, Hero $playerWhoDefense)
    {
        if (true === $playerWhoDefense->blockAttack()) {
            $this->output->writeln('Attack was blocked 🛡️');
        } else {
            $attackValue = $playerWhoAttack->getAttackValue();
            $attackValue =  $playerWhoDefense->makeDamage($attackValue);
            $this->output->writeln("{$playerWhoAttack->getName()} make {$attackValue} of damage 🩸🩸🩸");
        }
    }

    private function finishFightResult(FightResult $fightResult, Hero $winner, Hero $loser): FightResult
    {
        $fightResult->setWinner($winner);
        $fightResult->setLoser($loser);

        $this->notify($fightResult);
        return $fightResult;

        /*        if ($this->didPlayerDie($ai)) {
                return $this->finishFightResult($fightResult, $player, $ai);
            }
            */
    }

    private function notify(FightResult $fightResult): void
    {
        foreach ($this->observers as $observer) {
            $observer->onFightFinished($fightResult);
        }
    }
}
