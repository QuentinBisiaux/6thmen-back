<?php

namespace App\Repository\Admin;

use App\Entity\Admin\HypeScore;
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

}