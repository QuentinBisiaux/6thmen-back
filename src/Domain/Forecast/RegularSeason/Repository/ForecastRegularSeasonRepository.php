<?php

namespace App\Domain\Forecast\RegularSeason\Repository;

use App\Domain\Auth\Entity\User;
use App\Domain\Forecast\RegularSeason\Entity\ForecastRegularSeason;
use App\Domain\League\Entity\Season;
use App\Infrastructure\Context\Context;
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

    public function findUserForecastRegularSeason(User $user, Season $season, array $dates): ?ForecastRegularSeason
    {
        return $this->createQueryBuilder('ps')
            ->where('ps.user = :user')
            ->andWhere('ps.season = :season')
            ->andWhere('ps.createdAt >= :startAt')
            ->andWhere('ps.createdAt <= :endAt')
            ->setParameters([
                'user'      => $user,
                'season'    => $season,
                'startAt'   => $dates['startAt'],
                'endAt'     => $dates['endAt']

            ])
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}
