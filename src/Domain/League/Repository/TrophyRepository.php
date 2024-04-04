<?php

namespace App\Domain\League\Repository;

use App\Domain\League\Entity\Trophy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trophy>
 *
 * @method Trophy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trophy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trophy[]    findAll()
 * @method Trophy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrophyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trophy::class);
    }

    public function save(Trophy $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Trophy $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
