<?php

namespace App\Repository;

use App\Entity\ManagementType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ManagementType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ManagementType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ManagementType[]    findAll()
 * @method ManagementType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManagementTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ManagementType::class);
    }

    // /**
    //  * @return ManagementType[] Returns an array of ManagementType objects
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
    public function findOneBySomeField($value): ?ManagementType
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
