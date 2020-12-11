<?php

namespace App\Repository;

use App\Entity\RelationshipType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RelationshipType|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelationshipType|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelationshipType[]    findAll()
 * @method RelationshipType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelationshipTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelationshipType::class);
    }

    // /**
    //  * @return RelationshipType[] Returns an array of RelationshipType objects
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
    public function findOneBySomeField($value): ?RelationshipType
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
