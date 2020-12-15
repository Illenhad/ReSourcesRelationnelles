<?php

namespace App\Repository;

use App\Entity\ModerationType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ModerationType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModerationType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModerationType[]    findAll()
 * @method ModerationType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModerationTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModerationType::class);
    }

    // /**
    //  * @return ModerationType[] Returns an array of ModerationType objects
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
    public function findOneBySomeField($value): ?ModerationType
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
