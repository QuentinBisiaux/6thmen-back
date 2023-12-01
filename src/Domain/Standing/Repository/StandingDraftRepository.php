<?php

namespace App\Domain\Standing\Repository;

use App\Domain\League\Entity\Season;
use App\Domain\Standing\Entity\StandingDraft;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StandingDraft>
 *
 * @method StandingDraft|null find($id, $lockMode = null, $lockVersion = null)
 * @method StandingDraft|null findOneBy(array $criteria, array $orderBy = null)
 * @method StandingDraft[]    findAll()
 * @method StandingDraft[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StandingDraftRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StandingDraft::class);
    }

    public function save(StandingDraft $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StandingDraft $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByYearToPreLottery(Season $season): array
    {
        return $this->findBy(['season' => $season], ['rank' => 'DESC']);
    }

//    /**
//     * @return Standing[] Returns an array of Standing objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Standing
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
