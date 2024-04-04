<?php

namespace App\Domain\Forecast\Trophy\Repository;

use App\Domain\Auth\Entity\UserProfile;
use App\Domain\Forecast\Trophy\Entity\TrophyForecast;
use App\Domain\League\Entity\Trophy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrophyForecast>
 *
 * @method TrophyForecast|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrophyForecast|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrophyForecast[]    findAll()
 * @method TrophyForecast[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrophyForecastRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrophyForecast::class);
    }

    public function save(TrophyForecast $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TrophyForecast $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findUserTrophyForecast(UserProfile $userProfile, Trophy $trophy, array $date): array
    {
        return $this->createQueryBuilder('tf')
            ->where('tf.userProfile = :user_profile')
            ->andWhere('tf.trophy = :trophy')
            ->andWhere('tf.createdAt >= :startAt')
            ->andWhere('tf.createdAt <= :endAt')
            ->setParameters([
                'user_profile'  => $userProfile,
                'trophy'        => $trophy,
                'startAt'       => $date['startAt'],
                'endAt'         => $date['endAt']
            ])
            ->getQuery()
            ->getResult();
    }

}
