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
        $query = $entityManager->createQuery('DELETE FROM App\Entity\Admin\HypeScore');
        return $query->execute();
    }

    public function findAllForTop100()
    {
        return $this->createQueryBuilder('h')
            ->select('player.id AS id, CONCAT(player.firstname, \' \', player.lastname) AS name, h.score')
            ->join('h.player', 'player')
            ->groupBy('id', 'h.score')
            ->orderBy('h.score', 'DESC')
            ->getQuery()
            ->getResult();
    }

}