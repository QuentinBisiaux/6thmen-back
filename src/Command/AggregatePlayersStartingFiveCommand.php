<?php

namespace App\Command;

use App\Domain\Player\Entity\Position;
use App\Domain\Ranking\StartingFive\Entity\StartingFiveAggregator;
use App\Domain\Ranking\StartingFive\Entity\StartingFivePlayer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'aggregate:players:starting-five',
    description: 'cron launched',
)]
class AggregatePlayersStartingFiveCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $deleted = $this->entityManager->getRepository(StartingFiveAggregator::class)->deleteAll();

        $io->success('Nombre de lignes supprimées : ' . $deleted);
        $results = $this->entityManager->getRepository(StartingFivePlayer::class)->getAllWithPlayerSelected();
        $cleanedData = $this->prepareInsertion($results);

        foreach ($cleanedData as $details) {
            foreach ($details['position'] as $position => $count) {
                $startingFiveAggregation = new StartingFiveAggregator();
                $startingFiveAggregation->setPosition(Position::NUMBER_POSITION_BY_POSITION[$position]);
                $startingFiveAggregation->setPlayer($details['player']);
                $startingFiveAggregation->setCount($count);
                $this->entityManager->persist($startingFiveAggregation);
            }
        }
        $this->entityManager->flush();
        return Command::SUCCESS;
    }

    private function prepareInsertion(array $rawResults): array
    {
        $cleanedData = [];
        foreach ($rawResults as $startingFivePlayer) {
            $player = $startingFivePlayer->getPlayer();
            if (!array_key_exists($player->getId(), $cleanedData)) {
                $cleanedData[$player->getId()]['player']                                        = $player;
                $cleanedData[$player->getId()]['position'][$startingFivePlayer->getPosition()]  = 1;
            } else {
                $cleanedData[$player->getId()]['position'][$startingFivePlayer->getPosition()]  += 1;
            }
        }
        return $cleanedData;
    }

}
