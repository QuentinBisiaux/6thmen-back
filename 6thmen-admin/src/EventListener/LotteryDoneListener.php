<?php

namespace App\EventListener;

use App\Entity\StatLottery;
use App\Entity\Team;
use App\Event\LotteryDoneEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;


final class LotteryDoneListener
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
    #[AsEventListener(event: 'lottery.done')]
    public function lotteryDone(LotteryDoneEvent $lottery): void
    {

        /** @var Team[] $result */
        $result = $lottery->getResult();
        $toStore = [];
        foreach ($result as $team) {
            $toStore[] = $team->getId();
        }

        $statLottery = new StatLottery();
        $statLottery->setResult($toStore);
        $statLottery->setDoneAt(new \DateTimeImmutable());

        $this->entityManager->persist($statLottery);
        $this->entityManager->flush();
    }
}