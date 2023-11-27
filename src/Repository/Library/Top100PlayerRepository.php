<?php

namespace App\Repository\Library;

use App\Entity\Library\Top100Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Top100Player>
 *
 * @method Top100Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Top100Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Top100Player[]    findAll()
 * @method Top100Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Top100PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Top100Player::class);
    }

}