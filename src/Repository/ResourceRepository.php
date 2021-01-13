<?php

namespace App\Repository;

use App\Entity\Resource;
use App\Search\FilterData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
    public function findPublicQuery(FilterData $filterData, $dateCreationSorting = 'ASC'): Query
    {
        $query = $this->createQueryBuilder('r')
            ->select('t', 'rel', 'a', 'r')
            ->join('r.resourceType', 't')
            ->join('r.ageCategory', 'a')
            ->join('r.relationShip', 'rel')
            ->andWhere('r.public = 1')
            ->orderBy('r.dateCreation', $dateCreationSorting)
        ;

        if ($filterData->getType()) {
            $query->andWhere('t.id IN (:type)')
                ->setParameter('type', $filterData->getType());
        }

        if ($filterData->getAge()) {
            $query->andWhere('a.id IN (:age)')
                  ->setParameter('age', $filterData->getAge());
        }

        if ($filterData->getRelation()) {
            $query->andWhere('rel.id IN (:relationShip)')
                ->setParameter('relationShip', $filterData->getRelation());
        }

        return $query->getQuery();
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
