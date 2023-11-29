<?php

namespace App\Command;

use App\Entity\Admin\HypeScore;
use App\Entity\Admin\StartingFiveAggregator;
use App\Entity\Admin\Top100Aggregator;
use App\Entity\Library\Player;
use App\Entity\Library\StartingFive;
use App\Entity\Library\Top100Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'aggregate:players:hype-score',
    description: 'cron launched',
)]
class aggregatePlayerHypeScore extends Command
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

        $deleted = $this->entityManager->getRepository(HypeScore::class)->deleteAll();

        $io->success('Nombre de lignes supprimées : ' . $deleted);
        $startingFiveAggregations   = $this->entityManager->getRepository(StartingFiveAggregator::class)->findAll();
        $top100Aggregations         = $this->entityManager->getRepository(Top100Aggregator::class)->findAll();
        $hypeScores                 = $this->prepareHighScore(array_merge($startingFiveAggregations, $top100Aggregations));
        foreach ($hypeScores as $playerId => $details) {
            $hypeScore = new HypeScore();
            $hypeScore->setPlayer($details['player']);
            $hypeScore->setScore($details['score']);
            $this->entityManager->persist($hypeScore);
        }
        $this->entityManager->flush();

        return Command::SUCCESS;
    }


    private function prepareHighScore(array $allPlayers): array {
        $cleanedData = [];
        foreach ($allPlayers as $playerData) {
            $player = $playerData->getPlayer();
            if(!array_key_exists($player->getId(), $cleanedData)) {
                $cleanedData[$player->getId()]['player']    = $player;
                $cleanedData[$player->getId()]['score']     = $playerData->getCount();
            } else {
                $cleanedData[$player->getId()]['score']         += $playerData->getCount();
            }
        }
        return $cleanedData;
    }
}
