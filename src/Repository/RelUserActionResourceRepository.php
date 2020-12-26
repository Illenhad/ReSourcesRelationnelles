<?php

namespace App\Repository;

use App\Entity\RelUserActionResource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RelUserActionResource|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelUserActionResource|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelUserActionResource[]    findAll()
 * @method RelUserActionResource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelUserActionResourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelUserActionResource::class);
    }

    // /**
    //  * @return RelUserActionResource[] Returns an array of RelUserActionResource objects
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
    public function findOneBySomeField($value): ?RelUserActionResource
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
