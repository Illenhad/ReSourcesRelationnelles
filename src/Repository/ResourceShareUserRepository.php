<?php

namespace App\Repository;

use App\Entity\ResourceShareUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResourceShareUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResourceShareUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResourceShareUser[]    findAll()
 * @method ResourceShareUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResourceShareUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResourceShareUser::class);
    }

    public function getNumberOfWaitingResource(int $sharedId) {
        $query = $this->createQueryBuilder('rsu')
            ->select('count(rsu.id)')
            ->andWhere('rsu.shared = :shared')
            ->setParameter('shared', $sharedId)
        ;
        $count = $query->getQuery()->getSingleScalarResult();
        return $count;
    }

    public function getWaitingResources(int $sharedId) {
        $query = $this->createQueryBuilder('rsu')
            ->andWhere('rsu.shared = :userId')
            ->setParameter('userId', $sharedId)
        ;
        return $query->getQuery()->getResult();
    }
}
