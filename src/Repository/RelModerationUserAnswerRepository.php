<?php

namespace App\Repository;

use App\Entity\RelModerationUserAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RelModerationUserAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelModerationUserAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelModerationUserAnswer[]    findAll()
 * @method RelModerationUserAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelModerationUserAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelModerationUserAnswer::class);
    }

    // /**
    //  * @return RelModerationUserAnswer[] Returns an array of RelModerationUserAnswer objects
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
    public function findOneBySomeField($value): ?RelModerationUserAnswer
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
