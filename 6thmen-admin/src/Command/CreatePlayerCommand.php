<?php

namespace App\Command;

use App\Entity\Country;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'create:player',
    description: 'Add a short description for your command',
)]
class CreatePlayerCommand extends Command
{


    public function __construct(
        private EntityManagerInterface $manager,
    )
    {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('line', InputArgument::OPTIONAL, 'Argument description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $playerLine = $input->getArgument('line');
        $playerDataArray = explode(';', $playerLine);

        $names = explode(' ', $playerDataArray[3]);
        $firstname    = array_shift($names);
        $lastname     = implode(' ', $names);

        $newPlayer = new Player();
        $newPlayer->setFirstname($firstname);
        $newPlayer->setLastname($lastname);
        $newPlayer->setBirthday(new \DateTimeImmutable($playerDataArray[7]));
        $country = $this->tryCountry($playerDataArray[8]);
        if ($country instanceof Country) {
            $newPlayer->setBirthPlace($country);
        }
        $newPlayer->setCreatedAt(new \DateTimeImmutable());
        $this->manager->persist($newPlayer);
        $this->manager->flush();

        return Command::SUCCESS;
    }

    private function tryCountry(string $country): ?Country
    {
        $countryRepo = $this->manager->getRepository(Country::class);
        $countryAlpha = $countryRepo->findOneBy(['alpha3' => $country]);
        if ($countryAlpha instanceof Country) {
            return $countryAlpha;
        }
        $countryName = $countryRepo->findOneBy(['name' => $country]);
        if ($countryName instanceof Country) {
            return $countryName;
        }
        return null;
    }

}
