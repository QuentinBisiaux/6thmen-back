<?php

namespace App\Domain\Ranking\StartingFive\Repository;

use App\Domain\Auth\Entity\UserProfile;
use App\Domain\Ranking\StartingFive\Entity\StartingFive;
use App\Domain\Team\Franchise;
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

    public function findStartingFiveForUserAndTeam(UserProfile $user, Franchise $franchise): ?StartingFive
    {
        return $this->createQueryBuilder('sf')
            ->where('sf.user = :user')
            ->andWhere('sf.franchise = :franchise')
            ->setParameter('user', $user)
            ->setParameter('franchise', $franchise)
            ->getQuery()
            ->getOneOrNullResult();
    }
}