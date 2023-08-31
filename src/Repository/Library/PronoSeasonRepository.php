<?php

namespace App\Repository\Library;

use App\Entity\Library\PronoSeason;
use App\Entity\Library\Season;
use App\Entity\Library\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PronoSeason>
 *
 * @method PronoSeason|null find($id, $lockMode = null, $lockVersion = null)
 * @method PronoSeason|null findOneBy(array $criteria, array $orderBy = null)
 * @method PronoSeason[]    findAll()
 * @method PronoSeason[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PronoSeasonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PronoSeason::class);
    }

    public function save(PronoSeason $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PronoSeason $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findUserPronoForSeason(User $user, Season $season): array
    {
        return $this->createQueryBuilder('ps')
            ->where('ps.user = :userId')
            ->setParameter('userId', $user->getId())
            ->andWhere('ps.season = :seasonId')
            ->setParameter('seasonId', $season->getId())
            ->getQuery()
            ->getResult()
            ;

    }

//    /**
//     * @return PronoSeason[] Returns an array of PronoSeason objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PronoSeason
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
