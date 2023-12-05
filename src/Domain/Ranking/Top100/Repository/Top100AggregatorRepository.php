<?php

namespace App\Domain\Ranking\Top100\Repository;

use App\Domain\Ranking\Top100\Entity\Top100Aggregator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Top100Aggregator>
 *
 * @method Top100Aggregator|null find($id, $lockMode = null, $lockVersion = null)
 * @method Top100Aggregator|null findOneBy(array $criteria, array $orderBy = null)
 * @method Top100Aggregator[]    findAll()
 * @method Top100Aggregator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Top100AggregatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Top100Aggregator::class);
    }

    public function deleteAll()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('DELETE FROM ' . Top100Aggregator::class);
        return $query->execute();
    }

}