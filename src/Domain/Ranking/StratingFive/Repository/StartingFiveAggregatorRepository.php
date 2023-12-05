<?php

namespace App\Domain\Ranking\StratingFive\Repository;

use App\Domain\Ranking\StratingFive\Entity\StartingFiveAggregator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StartingFiveAggregator>
 *
 * @method StartingFiveAggregator|null find($id, $lockMode = null, $lockVersion = null)
 * @method StartingFiveAggregator|null findOneBy(array $criteria, array $orderBy = null)
 * @method StartingFiveAggregator[]    findAll()
 * @method StartingFiveAggregator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StartingFiveAggregatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StartingFiveAggregator::class);
    }

    public function deleteAll()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('DELETE FROM ' . StartingFiveAggregator::class);
        return $query->execute();
    }

    public function findAllForTop100()
    {
        return $this->createQueryBuilder('sfa')
            ->select('player.id AS id, CONCAT(player.firstname, \' \', player.lastname) AS name, SUM(sfa.count) AS total')
            ->join('sfa.player', 'player')
            ->groupBy('id')
            ->orderBy('total', 'DESC')
            ->getQuery()
            ->getResult();
    }

}