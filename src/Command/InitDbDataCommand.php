<?php

namespace App\Command;

use App\Entity\Library\Country;
use App\Entity\Library\League;
use App\Entity\Library\Season;
use App\Entity\Library\Sport;
use App\Service\FileManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[AsCommand(
    name: 'init:db:data',
    description: 'Add a short description for your command',
)]
class InitDbDataCommand extends Command
{
    private array $leaguesBySports = [
        'BasketBall' => ['ABA', 'BAA', 'NBA', 'NBL', 'NCAA', 'EUROLEAGUE'],
        'Soccer' => ['FIFA', 'UEFA'],
        'Football' => ['NFL']
    ];

    const CONST_PATH_COUNTRIES = __DIR__ . '/../../var/data/countries.csv';

    public function __construct(
        private FileManager $fileManager,
        private EntityManagerInterface $manager,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->leaguesBySports as $sport => $leagues) {
            $sportToInsert = new Sport();
            $sportToInsert->setName($sport);
            $sportToInsert->setCreatedAt(new \DateTimeImmutable());
            $this->manager->persist($sportToInsert);
            foreach ($leagues as $league) {
                $leagueToInsert = new League();
                $leagueToInsert->setName($league);
                $leagueToInsert->setCreatedAt(new \DateTimeImmutable());
                $leagueToInsert->setSport($sportToInsert);
                $this->manager->persist($leagueToInsert);
            }
        }
        $fileContent = file(__DIR__ . '/../../var/data/countries.csv');
        try {
            $fileContent = $this->fileManager->getFileContent(self::CONST_PATH_COUNTRIES);
        } catch (FileException $ex) {
            $output->error($ex->getMessage());
            return self::FAILURE;
        }
        array_shift($fileContent);
        foreach ($fileContent as $countryData) {
            $countryDataArray = explode(',', $countryData);
            $newCountry = new Country();
            $newCountry->setName($countryDataArray[0]);
            $newCountry->setAlpha2($countryDataArray[1]);
            $newCountry->setAlpha3($countryDataArray[2]);
            $newCountry->setCode($countryDataArray[3]);
            $newCountry->setRegion($countryDataArray[5]);
            $newCountry->setCreatedAt(new \DateTimeImmutable());
            $this->manager->persist($newCountry);
        }
        for ($startingYear = 1850; $startingYear <= 2150; $startingYear++) {
            $season = new Season();
            $season->setYear($startingYear);
            $season->setCreatedAt(new \DateTimeImmutable());
            $this->manager->persist($season);
            $this->manager->flush();
            $seasonMult = new Season();
            $seasonMult->setYear($startingYear . '-' . substr($startingYear + 1, -2));
            $seasonMult->setCreatedAt(new \DateTimeImmutable());
            $this->manager->persist($seasonMult);
        }
        $this->manager->flush();
        return self::SUCCESS;
    }

}