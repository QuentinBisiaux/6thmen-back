<?php

namespace App\Repository\Library;

use App\Entity\Library\ForecastRegularSeason;
use App\Entity\Library\Season;
use App\Entity\Library\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ForecastRegularSeason>
 *
 * @method ForecastRegularSeason|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForecastRegularSeason|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForecastRegularSeason[]    findAll()
 * @method ForecastRegularSeason[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForecastRegularSeasonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForecastRegularSeason::class);
    }

    public function save(ForecastRegularSeason $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ForecastRegularSeason $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findUserForecastRegularSeason(User $user, Season $season): ?ForecastRegularSeason
    {
        $userForecast = $this->createQueryBuilder('ps')
            ->where('ps.user = :userId')
            ->setParameter('userId', $user->getId())
            ->andWhere('ps.season = :seasonId')
            ->setParameter('seasonId', $season->getId())
            ->getQuery()
            ->getResult()
            ;
        return $userForecast[0] ?? null;
    }
}
