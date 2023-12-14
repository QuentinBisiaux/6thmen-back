<?php

namespace App\Domain\Forecast\Trophy\Repository;

use App\Domain\Auth\Entity\UserProfile;
use App\Domain\Forecast\Trophy\Entity\Trophy;
use App\Domain\Forecast\Trophy\Entity\TrophyForecast;
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

    public function findUserTrophyForecast(UserProfile $userProfile, Trophy $trophy)
    {
        return $this->createQueryBuilder('tf')
            ->where('tf.userProfile = :user_profile')
            ->andWhere('tf.trophy = :trophy')
            ->setParameter('user_profile', $userProfile)
            ->setParameter('trophy', $trophy)
            ->getQuery()
            ->getResult();

    }

}
