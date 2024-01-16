<?php

namespace App\Domain\League\Repository;

use App\Domain\League\Entity\Competition;
use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Season;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Competition>
 *
 * @method Competition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Competition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Competition[]    findAll()
 * @method Competition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Competition::class);
    }

    public function save(Competition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Competition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPlayingCompetition(League $league, Season $season): ?Competition
    {
        return $this->createQueryBuilder('c')
            ->where('c.season = :season')
            ->andWhere('c.league = :league')
            ->andWhere('c.startAt <= :startAt')
            ->andWhere('c.endAt >= :endAt')
            ->setParameters([
                'season' => $season,
                'league' => $league,
                'startAt' => new \DateTimeImmutable(),
                'endAt' => new \DateTimeImmutable()
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findLastCompetition(Season $season, League $league, string $competitionName): ?Competition
    {
        return $this->createQueryBuilder('c')
            ->where('c.season = :season')
            ->andWhere('c.league <= :league')
            ->andWhere('c.name = :name')
            ->andWhere('c.endAt <= :endAt')
            ->setParameters([
                'season' => $season,
                'league' => $league,
                'name' => $competitionName,
                'endAt' => new \DateTimeImmutable()
            ])
            ->orderBy('c.endAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return League[] Returns an array of League objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?League
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
