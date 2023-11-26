<?php

namespace App\Command;

use App\Entity\Admin\StartingFiveAggregator;
use App\Entity\Library\Player;
use App\Entity\Library\StartingFive;
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
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $deleted = $this->entityManager->getRepository(StartingFiveAggregator::class)->deleteAll();

        $io->success('Nombre de lignes supprimées : ' . $deleted);
        $results = $this->entityManager->getRepository(StartingFive::class)->countPlayerPositions();

        foreach ($results as $position => $details) {
            foreach ($details as $playerIdAndCount) {
                $startingFiveAggregation = new StartingFiveAggregator();
                $startingFiveAggregation->setPosition($position);
                $player = $this->entityManager->getRepository(Player::class)->findOneById($playerIdAndCount['player_id']);
                $startingFiveAggregation->setPlayer($player);
                $startingFiveAggregation->setCount((int) $playerIdAndCount['count']);
                $this->entityManager->persist($startingFiveAggregation);
            }
        }
        $this->entityManager->flush();

//        $io->success('Nombre de lignes supprimées : ' . $deleted);


        return Command::SUCCESS;
    }
}
