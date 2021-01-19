<?php

namespace App\Repository;

use App\Entity\RelSharedResourceUser;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RelSharedResourceUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelSharedResourceUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelSharedResourceUser[]    findAll()
 * @method RelSharedResourceUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelSharedResourcesUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelSharedResourceUser::class);
    }

    public function getCurrentDaySharedResourceNumber() {
        $manager = $this->getEntityManager();

        $query = $manager->createQuery('
            SELECT count(r)
            FROM App\Entity\RelSharedResourceUser r
            WHERE r.shareDate BETWEEN :date1 AND :date2
        ')-> setParameter('date1', new DateTime('today'))
        ->setParameter('date2', new DateTime('now'));

        return $query->getScalarResult()[0][1];
    }

    // /**
    //  * @return RelSharedResourceUser[] Returns an array of RelSharedResourceUser objects
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
    public function findOneBySomeField($value): ?RelSharedResourceUser
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
