<?php

namespace App\Repository\Library;

use App\Entity\Library\Top100;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Top100>
 *
 * @method Top100|null find($id, $lockMode = null, $lockVersion = null)
 * @method Top100|null findOneBy(array $criteria, array $orderBy = null)
 * @method Top100[]    findAll()
 * @method Top100[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Top100Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Top100::class);
    }

}