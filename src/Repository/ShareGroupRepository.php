<?php

namespace App\Repository;

use App\Entity\ShareGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShareGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShareGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShareGroup[]    findAll()
 * @method ShareGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShareGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShareGroup::class);
    }

    // /**
    //  * @return ShareGroup[] Returns an array of ShareGroup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShareGroup
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
