<?php

namespace App\Repository;

use App\Entity\RelModerationUserResource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RelModerationUserResource|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelModerationUserResource|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelModerationUserResource[]    findAll()
 * @method RelModerationUserResource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelModerationUserResourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelModerationUserResource::class);
    }

    // /**
    //  * @return RelModerationUserResource[] Returns an array of RelModerationUserResource objects
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
    public function findOneBySomeField($value): ?RelModerationUserResource
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
