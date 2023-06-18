<?php

namespace App\Command;

use App\Entity\Lottery;
use App\Repository\TeamRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'testDraft',
    description: 'Add a short description for your command',
)]
class TestDraftCommand extends Command
{
    public function __construct(private TeamRepository $teamRepository)
    {
        parent::__construct();

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $results = [];
        foreach ($this->teamRepository->findAll() as $team) {
            $results[$team->getName()] = 0;
        }

        $progressBar = new ProgressBar($output, 100000);
        $progressBar->start();
        for ($x = 0; $x < 100000; $x++) {
            $lottery = new Lottery($this->teamRepository);
            $result = $lottery->getResults();
            $results[$result[0]->getName()] += 1;

            $progressBar->advance();
        }
        $progressBar->finish();
        $finalResults = [];
        foreach ($results as $index => $result) {
            $finalResults[$index]['result'] = $result;
            $finalResults[$index]['percentage'] = $result / 100000 * 100;
        }
        //dump($finalResults);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
