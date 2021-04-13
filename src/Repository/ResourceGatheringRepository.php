<?php

namespace App\Repository;

use App\Entity\ResourceGathering;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResourceGathering|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResourceGathering|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResourceGathering[]    findAll()
 * @method ResourceGathering[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResourceGatheringRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResourceGathering::class);
    }
}
