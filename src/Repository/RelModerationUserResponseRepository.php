<?php

namespace App\Repository;

use App\Entity\RelModerationUserResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RelModerationUserResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelModerationUserResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelModerationUserResponse[]    findAll()
 * @method RelModerationUserResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelModerationUserResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelModerationUserResponse::class);
    }

    // /**
    //  * @return RelModerationUserResponse[] Returns an array of RelModerationUserResponse objects
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
    public function findOneBySomeField($value): ?RelModerationUserResponse
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
