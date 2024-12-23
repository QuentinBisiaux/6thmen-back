<?php

namespace App\Repository\Library;

use App\Entity\Library\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Team>
 *
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    public function save(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllWithLeague(): array
    {
        return $this->createQueryBuilder('team')
            ->leftJoin('team.league', 'league')
            ->leftJoin('team.sisterTeam', 'sisterTeam')
            ->addSelect('league')
            ->addSelect('sisterTeam')
            ->getQuery()
            ->getResult();
    }

    public function actualTeams(): array
    {
        return $this->createQueryBuilder('team')
            ->where('team.endedIn IS NULL')
            ->getQuery()
            ->getResult();
    }

    public function actualTeamsByConference(): array
    {
        return $this->createQueryBuilder('team')
            ->where('team.endedIn IS NULL')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Team[] Returns an array of Team objects
     */
    public function findTeamsByNameOrdered(): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.endedIn IS NULL')
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Team[] Returns an array of Team objects
     */
    public function findTeamAndSisters(int $id): array
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.sisterTeam', 's')
            ->where('t.id = :teamId OR s.id = :teamId')
            ->setParameter('teamId', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findTeamsByIds(array $ids): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.id IN (:teamIds)')
            ->setParameter('teamIds', $ids)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByNameAndDate(string $name, \DateTimeImmutable $date): ?Team
    {
        $qb = $this->createQueryBuilder('t');

        $qb->where('t.name = :name')
            ->setParameter('name', $name)
            ->andWhere($qb->expr()->orX(
                $qb->expr()->isNull('t.endedIn'),
                $qb->expr()->gte('t.endedIn', ':date')
            ))
            ->setParameter('date', $date)
            ->andWhere('t.createdIn <= :date');

        return $qb->getQuery()->getOneOrNullResult();
    }

//    /**
//     * @return Team[] Returns an array of Team objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Team
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
