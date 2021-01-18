<?php

namespace App\Repository;

use App\Entity\RelUserManagementResource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RelUserManagementResource|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelUserManagementResource|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelUserManagementResource[]    findAll()
 * @method RelUserManagementResource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelUserManagementResourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelUserManagementResource::class);
    }

    // /**
    //  * @return RelUserManagementResourceFixture[] Returns an array of RelUserManagementResourceFixture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RelUserManagementResourceFixture
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
