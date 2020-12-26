<?php

namespace App\Repository;

use App\Entity\RelShareGroupUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RelShareGroupUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelShareGroupUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelShareGroupUser[]    findAll()
 * @method RelShareGroupUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelShareGroupUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelShareGroupUser::class);
    }

    // /**
    //  * @return RelShareGroupUser[] Returns an array of RelShareGroupUser objects
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
    public function findOneBySomeField($value): ?RelShareGroupUser
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
