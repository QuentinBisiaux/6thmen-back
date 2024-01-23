<?php

namespace App\Domain\Player\Repository;

use App\Domain\League\Entity\Season;
use App\Domain\Player\Entity\Player;
use App\Domain\Team\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Player>
 *
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    public function save(Player $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Player $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPlayersByNameAndWithoutSomeId(string $name, array $excludedIds): array
    {
        $qb = $this->createQueryBuilder('p');
        $qb ->where($qb->expr()->like('CONCAT(LOWER(p.firstname), \' \', LOWER(p.lastname))', ':name'))
            ->setParameter('name', '%' . strtolower($name) . '%');
        if(!empty($excludedIds)) {
            $qb->andWhere($qb->expr()->notIn('p.id', ':excludedIds'))
                ->setParameter('excludedIds', $excludedIds);
        }
         return $qb->setMaxResults(25)->getQuery()->getResult();

    }

    public function getCurrentPlayers(Season $season): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.playerTeams', 'pt')
            ->where('pt.season = :season')
            ->setParameter('season', $season)
            ->groupBy('p.id')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getCurrentRookies(Season $season): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.playerTeams', 'pt')
            ->where('pt.season = :season')
            ->setParameter('season', $season)
            ->andWhere('pt.experience = :experience')
            ->setParameter('experience', 0)
            ->groupBy('p.id')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getCurrentPlayersWithMoreThan2Seasons(Season $season): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.playerTeams', 'pt')
            ->groupBy('p.id')
            ->where('pt.season = :season')
            ->setParameter('season', $season)
            ->andWhere('pt.experience >= :experience')
            ->setParameter('experience', 2)
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return Player[] Returns an array of Player objects
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

//    public function findOneBySomeField($value): ?Player
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
