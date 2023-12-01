<?php

namespace App\Command;

use App\Domain\Ranking\Top100\Entity\Top100Aggregator;
use App\Domain\Ranking\Top100\Entity\Top100Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'aggregate:players:top100',
    description: 'cron launched',
)]
class AggregatePlayersTop100Command extends Command
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

        $deleted = $this->entityManager->getRepository(Top100Aggregator::class)->deleteAll();

        $io->success('Nombre de lignes supprimées : ' . $deleted);
        $results = $this->entityManager->getRepository(Top100Player::class)->getAllWithPlayerSelected();
        $cleanedData = $this->prepareInsertion($results);
        foreach ($cleanedData as $playerId => $details) {
            $top100Aggregation = new Top100Aggregator();
            $top100Aggregation->setPlayer($details['player']);
            $top100Aggregation->setCount($details['count']);
            $this->entityManager->persist($top100Aggregation);
        }
        $this->entityManager->flush();


        return Command::SUCCESS;
    }

    private function prepareInsertion(array $rawResults): array {
        $cleanedData = [];
        foreach ($rawResults as $top100Player) {
            $player = $top100Player->getPlayer();
            if(!array_key_exists($player->getId(), $cleanedData)) {
                $cleanedData[$player->getId()]['player']    = $player;
                $cleanedData[$player->getId()]['count']     = 101 - $top100Player->getRank();
            } else {
                $cleanedData[$player->getId()]['count']     += 101 - $top100Player->getRank();
            }
        }
        return $cleanedData;
    }
}
