<?php

namespace App\Repository;

use App\Entity\Gathering;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gathering|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gathering|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gathering[]    findAll()
 * @method Gathering[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GatheringRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gathering::class);
    }
}
