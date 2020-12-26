<?php

namespace App\Repository;

use App\Entity\ModerationDate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ModerationDate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModerationDate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModerationDate[]    findAll()
 * @method ModerationDate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModerationDateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModerationDate::class);
    }

    // /**
    //  * @return ModerationDate[] Returns an array of ModerationDate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ModerationDate
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
