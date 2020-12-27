<?php

namespace App\Repository;

use App\Entity\ManagementType;
use App\Entity\Resource;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method resource|null find($id, $lockMode = null, $lockVersion = null)
 * @method resource|null findOneBy(array $criteria, array $orderBy = null)
 * @method resource[]    findAll()
 * @method resource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resource::class);
    }

//    /**
//     * Cette méthode retourne les ressources qui ne necessitent  pas d'être authentifié.
//     *
//     * @return resource[]
//     */
//    public function findPublic($dateCreationSorting = 'DESC')
//    {
//        return $this->findBy(
//            ['public' => 1],
//            [
//                'dateCreation' => $dateCreationSorting,
//            ]
//        );
//    }

    /**
     * Cette méthode retourne les ressources qui ne necessitent  pas d'être authentifié.
     *
     * @param string $dateCreationSorting
     */
    public function findPublicQuery($dateCreationSorting = 'ASC'): Query
    {
        return ($this->createQueryBuilder('r'))
            ->where('r.public = 1')
            ->orderBy('r.dateCreation', $dateCreationSorting)
            ->getQuery()
        ;
    }

    // /**
    //  * @return Resource[] Returns an array of Resource objects
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
    public function findOneBySomeField($value): ?Resource
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
