<?php

namespace App\Domain\Player\Repository;

use App\Domain\Player\Entity\HypeScore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HypeScore>
 *
 * @method HypeScore|null find($id, $lockMode = null, $lockVersion = null)
 * @method HypeScore|null findOneBy(array $criteria, array $orderBy = null)
 * @method HypeScore[]    findAll()
 * @method HypeScore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HypeScoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HypeScore::class);
    }

    public function deleteAll()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('DELETE FROM ' . HypeScore::class);
        return $query->execute();
    }

    public function findAllForTop100()
    {
        return  $this->createQueryBuilder('h')
            ->join('h.player', 'p')
            ->where('h.score IS NOT NULL')
            ->groupBy('h.id', 'h.score')
            ->orderBy('h.score', 'DESC')
            ->setMaxResults(200)
            ->getQuery()
            ->getResult();
    }

}