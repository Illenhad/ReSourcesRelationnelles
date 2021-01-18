<?php

namespace App\Repository;

use App\Entity\Resource;
use App\Entity\User;
use App\Search\FilterData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
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
     * @param FilterData $filterData
     * @param string|null $search
     * @param string $dateCreationSorting
     * @return Query
     */
    public function findPublicQuery(FilterData $filterData, ?string $search, $dateCreationSorting = 'ASC'): Query
    {
        $query = $this->createQueryBuilder('r')
            ->select('t', 'rel', 'a', 'r')
            ->join('r.resourceType', 't')
            ->join('r.ageCategory', 'a')
            ->join('r.relationShip', 'rel')
            ->andWhere('r.public = 1')
            ->orderBy('r.dateCreation', $dateCreationSorting)
        ;

        if ($search) {
            $query->andWhere('r.title LIKE :search OR r.description LIKE :search' )
                ->setParameter('search', '%'.$search.'%');
        }

        if ($filterData->getSearch()) {
            $query->andWhere('r.title LIKE :search')
                ->setParameter('search', '%'.$filterData->getSearch().'%');
        }

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

    public function getMostCommentedResources() {

        $connexion = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM resource
            WHERE id IN (
                SELECT resource_id FROM (
                    SELECT resource_id, DATE_FORMAT(comment_date, \'%m/%d/%Y\')
                    FROM comment 
                    WHERE comment_date BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() + INTERVAL 1 DAY) t
                    group by t.resource_id
                    order by count(resource_id) DESC 
                ) limit 4';

        try {
            $statement = $connexion->prepare($sql);
            $statement->execute();
            $tabResources = [];
            $i = 0;
            foreach ($statement->fetchAllAssociative() as $row) {
                $tabResources[$i] = $this->getEntityManager()->getRepository(Resource::class)->find($row['id']);
                $i++;
            }
            return $tabResources;
        } catch (Exception $e) {
            return [];
        } catch (\Doctrine\DBAL\Driver\Exception $e) {
            return [];
        }

    }

    public function getCurrentDayConsultedResources() {

        $connexion = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT t.resource_id FROM (
                SELECT resource_id, count(resource_id)
                FROM rel_user_action_resource 
                WHERE action_type_id = :actionTypeId
                AND action_date BETWEEN :date1 AND :date2
                GROUP BY resource_id
                ORDER BY count(resource_id)
                LIMIT 3) t
        ';

        try {
            $statement = $connexion->prepare($sql);
            $actionTypeId = 2;
            $date1 = date_format(new \DateTime('today'), "Y-m-d H:i:s");
            $date2 = date_format(new \DateTime('now'), "Y-m-d H:i:s");
            $statement->bindValue(':actionTypeId', $actionTypeId);
            $statement->bindValue(':date1', $date1);
            $statement->bindValue(':date2', $date2);
            $statement->execute();
            $tabResources = [];
            $i = 0;

            foreach ($statement->fetchAllAssociative() as $row) {
                $tabResources[$i] = $this->getEntityManager()->getRepository(Resource::class)->find($row['resource_id']);
                $i++;
            }

            return $tabResources;
        } catch (Exception $e) {
            return [];
        } catch (\Doctrine\DBAL\Driver\Exception $e) {
            return [];
        }

    }

    public function getCurrentDaySharedResources() {

        $connexion = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT t.resource_id FROM (
                SELECT resource_id, count(resource_id)
                FROM rel_shared_resource_user
                WHERE share_date BETWEEN :date1 AND :date2
                GROUP BY resource_id
                ORDER BY count(resource_id)
                LIMIT 3) t
        ';

        try {
            $statement = $connexion->prepare($sql);
            $date1 = date_format(new \DateTime('today'), "Y-m-d H:i:s");
            $date2 = date_format(new \DateTime('now'), "Y-m-d H:i:s");
            $statement->bindValue(':date1', $date1);
            $statement->bindValue(':date2', $date2);
            $statement->execute();
            $tabResources = [];
            $i = 0;

            foreach ($statement->fetchAllAssociative() as $row) {
                $tabResources[$i] = $this->getEntityManager()->getRepository(Resource::class)->find($row['resource_id']);
                $i++;
            }

            return $tabResources;
        } catch (Exception $e) {
            return [];
        } catch (\Doctrine\DBAL\Driver\Exception $e) {
            return [];
        }

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
