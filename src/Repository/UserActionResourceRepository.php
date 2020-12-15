<?php

namespace App\Repository;

use App\Entity\UserActionResource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserActionResource|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserActionResource|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserActionResource[]    findAll()
 * @method UserActionResource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserActionResourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserActionResource::class);
    }

    // /**
    //  * @return UserActionResource[] Returns an array of UserActionResource objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserActionResource
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
