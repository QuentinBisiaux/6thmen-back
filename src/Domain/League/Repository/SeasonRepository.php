<?php

namespace App\Domain\League\Repository;

use App\Domain\League\Entity\Season;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Season>
 *
 * @method Season|null find($id, $lockMode = null, $lockVersion = null)
 * @method Season|null findOneBy(array $criteria, array $orderBy = null)
 * @method Season[]    findAll()
 * @method Season[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeasonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Season::class);
    }

    public function save(Season $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Season $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getCurrentSeason(): Season
    {
        $currentDate = (new \DateTimeImmutable())->format('Y');
        return $this->createQueryBuilder('s')
            ->where('s.year = :year')
            ->setParameter('year', $currentDate)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getMultiYearSeasonByYear(?string $date): Season
    {
        if (is_null($date)) {
            $currentDate = (new \DateTimeImmutable())->format('Y');
            $date = $currentDate . '-' . substr((string) ((int) $currentDate + 1), -2);
        }

        return $this->createQueryBuilder('s')
            ->where('s.year = :year')
            ->setParameter('year', $date)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllMultiSeasonBetween2Years(string $start, string $end): array
    {
        $startingSeason = $this->getMultiYearSeasonByYear($start. '-' . substr((string) ((int) $start + 1), -2));
        $endSeason = $this->getMultiYearSeasonByYear($end. '-' . substr((string) ((int) $end + 1), -2));
        $ids = [];
        for ($x = $startingSeason->getId(); $x <= $endSeason->getId(); $x+=2) {
            $ids[] = $x;
        }
        return $this->createQueryBuilder('s')
            ->where('s.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Season[] Returns an array of Season objects
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

//    public function findOneBySomeField($value): ?Season
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
