<?php

namespace App\Repository\Library;

use App\Entity\Library\StartingFivePlayer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StartingFivePlayer>
 *
 * @method StartingFivePlayer|null find($id, $lockMode = null, $lockVersion = null)
 * @method StartingFivePlayer|null findOneBy(array $criteria, array $orderBy = null)
 * @method StartingFivePlayer[]    findAll()
 * @method StartingFivePlayer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StartingFivePlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StartingFivePlayer::class);
    }

    public function getAllWithPlayerSelected()
    {
        return $this->createQueryBuilder('s')
            ->where('s.player IS NOT NULL')
            ->getQuery()
            ->getResult();
    }

}