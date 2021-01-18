<?php

namespace App\Repository;

use App\Entity\RelModerationUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RelModerationUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelModerationUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelModerationUser[]    findAll()
 * @method RelModerationUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelModerationUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelModerationUser::class);
    }

    // /**
    //  * @return RelModerationUser[] Returns an array of RelModerationUser objects
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
    public function findOneBySomeField($value): ?RelModerationUser
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
