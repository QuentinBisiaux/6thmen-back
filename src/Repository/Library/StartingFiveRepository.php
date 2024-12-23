<?php

namespace App\Repository\Library;

use App\Entity\Library\StartingFive;
use App\Entity\Library\Team;
use App\Entity\Library\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StartingFive>
 *
 * @method StartingFive|null find($id, $lockMode = null, $lockVersion = null)
 * @method StartingFive|null findOneBy(array $criteria, array $orderBy = null)
 * @method StartingFive[]    findAll()
 * @method StartingFive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StartingFiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StartingFive::class);
    }

    public function save(StartingFive $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StartingFive $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findStartingFiveForUserAndTeam(User $user, Team $team): ?StartingFive
    {
        return $this->createQueryBuilder('sf')
            ->where('sf.user = :user')
            ->andWhere('sf.team = :team')
            ->setParameter('user', $user)
            ->setParameter('team', $team)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findStartingFiveForUser(User $user): array
    {
        return $this->createQueryBuilder('sf')
            ->where('sf.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Country[] Returns an array of Country objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Country
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
