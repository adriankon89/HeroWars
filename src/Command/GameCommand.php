<?php

declare(strict_types=1);

namespace App\Command;

use App\Builder\CharacterBuilderFactory;
use App\GameApplication;
use App\GameResult;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\HttpKernel\Log\Logger;

class GameCommand extends Command
{
    protected function configure()
    {
        $this->setName('HeroWars')
            ->setDescription('Enter `Hero Wars` to enjoy some fun')
            ->setHelp('Play and win');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $gameApp = new GameApplication(
            $output,
            new CharacterBuilderFactory(new Logger()),
            new GameResult()
        );

        $characters = $gameApp->getCharacterList();
        $defaultCharacter = $gameApp->getDefaultCharacterName();
        $output->writeln('');

        $question = new ChoiceQuestion(
            "Please select your character (Default character is {$defaultCharacter})",
            $characters,
            $defaultCharacter
        );
        $question->setErrorMessage('Character value %s is invalid. Please try again');

        $helper = $this->getHelper('question');
        $playerCharacterType = $helper->ask($input, $output, $question);
        $output->writeln('You have just selected: ' . $playerCharacterType);
        $output->writeln('');

        $question = new ChoiceQuestion(
            "Please select character for second player (defaults is {$defaultCharacter})",
            $characters,
            $defaultCharacter
        );
        $question->setErrorMessage('Character %s is invalid.');

        $secondPlayerCharacterType = $helper->ask($input, $output, $question);
        $output->writeln("Second player selected character is: {$secondPlayerCharacterType}");

        $playerCharacter = $gameApp->createCharacter($playerCharacterType, 'player one');
        $playerTwoCharacter = $gameApp->createCharacter($secondPlayerCharacterType, 'player two');
        $gameApp->setPlayerOne($playerCharacter);
        $gameApp->setPlayerTwo($playerTwoCharacter);
        $gameApp->fight();
        // $this->printResult($fightResult, $player, $io);

        return Command::SUCCESS;
    }
}
