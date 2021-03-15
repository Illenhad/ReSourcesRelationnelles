<?php

namespace App\Repository;

use App\Entity\ActionType;
use App\Entity\ManagementType;
use App\Entity\Resource;
use App\Entity\User;
use App\Search\FilterData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
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
    public function findPublicQuery(FilterData $filterData, ?string $search, $dateCreationSorting = 'ASC'): Query
    {
        $query = $this->createQueryBuilder('r')
            ->select('r as resource', 'avg(comments.valuation) as note', 'count(commentaries.id) as nb_coms')
            ->leftjoin('r.resourceType', 't')
            ->leftjoin('r.ageCategory', 'a')
            ->leftjoin('r.relationShip', 'rel')
            ->leftjoin('r.comments', 'comments')
            ->leftjoin('r.commentaries', 'commentaries')
            ->andWhere('r.public = 1')
            ->andWhere('r.active = 1')
            ->groupBy('r')
        ;

        if ($search) {
            $query->andWhere('r.title LIKE :search OR r.description LIKE :search')
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

    public function getMostCommentedResources()
    {
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
                ++$i;
            }

            return $tabResources;
        } catch (Exception $e) {
            return [];
        } catch (\Doctrine\DBAL\Driver\Exception $e) {
            return [];
        }
    }

    public function getCurrentDayConsultedResources()
    {
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
            $date1 = date_format(new \DateTime('today'), 'Y-m-d H:i:s');
            $date2 = date_format(new \DateTime('now'), 'Y-m-d H:i:s');
            $statement->bindValue(':actionTypeId', $actionTypeId);
            $statement->bindValue(':date1', $date1);
            $statement->bindValue(':date2', $date2);
            $statement->execute();
            $tabResources = [];
            $i = 0;

            foreach ($statement->fetchAllAssociative() as $row) {
                $tabResources[$i] = $this->getEntityManager()->getRepository(Resource::class)->find($row['resource_id']);
                ++$i;
            }

            return $tabResources;
        } catch (Exception $e) {
            return [];
        } catch (\Doctrine\DBAL\Driver\Exception $e) {
            return [];
        }
    }

    public function getCurrentDaySharedResources()
    {
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
            $date1 = date_format(new \DateTime('today'), 'Y-m-d H:i:s');
            $date2 = date_format(new \DateTime('now'), 'Y-m-d H:i:s');
            $statement->bindValue(':date1', $date1);
            $statement->bindValue(':date2', $date2);
            $statement->execute();
            $tabResources = [];
            $i = 0;

            foreach ($statement->fetchAllAssociative() as $row) {
                $tabResources[$i] = $this->getEntityManager()->getRepository(Resource::class)->find($row['resource_id']);
                ++$i;
            }

            return $tabResources;
        } catch (Exception $e) {
            return [];
        } catch (\Doctrine\DBAL\Driver\Exception $e) {
            return [];
        }
    }

    public function getLastWeekResourcesByValuation($bestvaluation)
    {
        if ($bestvaluation) {
            $order = 'DESC';
        } else {
            $order = 'ASC';
        }

        $connexion = $this->getEntityManager()->getConnection();

        $sql = '
            select resource_id, sum(valuation)/count(resource_id) as valuation, count(resource_id) as resources_nb
            from comment
            where comment_date BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() + INTERVAL 1 DAY
            group by resource_id
            having count(resource_id) > 
                (select max(resource_nb)/2 FROM (
                    select resource_id, count(resource_id) as resource_nb
                    from comment
                    where comment_date BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() + INTERVAL 1 DAY
                    group by resource_id) 
                t)
            order by sum(valuation)/count(resource_id) '.$order.' , resources_nb desc
            limit 3
            ';

        try {
            $statement = $connexion->prepare($sql);
            $statement->execute();
            $tabResources = [];
            $i = 0;

            foreach ($statement->fetchAllAssociative() as $row) {
                $resource = $this->getEntityManager()->getRepository(Resource::class)->find($row['resource_id']);
                $resource->setValuation(round($row['valuation'], 1));
                $tabResources[$i] = $resource;
                ++$i;
            }

            return $tabResources;
        } catch (Exception $e) {
            return [];
        } catch (\Doctrine\DBAL\Driver\Exception $e) {
            return [];
        }
    }

    public function getLastWeekMostSharedResources()
    {
        $connexion = $this->getEntityManager()->getConnection();

        $sql = '
            select resource_id, count(resource_id) as resource_nb
            from rel_shared_resource_user
            where share_date BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE() + INTERVAL 1 DAY
            group by resource_id
            order by resource_nb desc
            limit 3
        ';

        try {
            $statement = $connexion->prepare($sql);
            $statement->execute();
            $tabResources = [];
            $i = 0;

            foreach ($statement->fetchAllAssociative() as $row) {
                $resource = $this->getEntityManager()->getRepository(Resource::class)->find($row['resource_id']);
                $resource->setShareNb($row['resource_nb']);
                $tabResources[$i] = $resource;
                ++$i;
            }

            return $tabResources;
        } catch (Exception $e) {
            return [];
        } catch (\Doctrine\DBAL\Driver\Exception $e) {
            return [];
        }
    }

    /**
     * @return int
     */
    public function getNumberOfResourceByManagementType(int $managementTypeId, User $user)
    {
        $manager = $this->getEntityManager();
        $managementType = $manager->getRepository(ManagementType::class)->find($managementTypeId);
        $query = $manager->createQuery(
            'SELECT COUNT(r) FROM App\Entity\RelUserManagementResource r
                WHERE r.user = :user
                AND r.managementType = :managementType'
        )
            ->setParameter('user', $user)
            ->setParameter('managementType', $managementType);

        return $query->getScalarResult()[0][1];
    }

    /**
     * @return mixed
     */
    public function getNumberOfSharedResource(User $user)
    {
        $manager = $this->getEntityManager();
        $query = $manager->createQuery(
            'SELECT COUNT(r) FROM App\Entity\RelSharedResourceUser r
                WHERE r.sharedWithUser = :user'
        )
            ->setParameter('user', $user);

        return $query->getScalarResult()[0][1];
    }

    /**
     * @return mixed
     */
    public function getNumberOfResourceByActionType(int $actionTypeId, User $user)
    {
        $manager = $this->getEntityManager();
        $actionType = $manager->getRepository(ActionType::class)->find($actionTypeId);
        $query = $manager->createQuery(
            'SELECT COUNT(r) FROM App\Entity\RelUserActionResource r
                WHERE r.user = :user
                AND r.actionType = :actionType'
        )
            ->setParameter('user', $user)
            ->setParameter('actionType', $actionType);

        return $query->getScalarResult()[0][1];
    }

    /**
     * @return int|mixed|string
     */
    public function getResourcesByManagementType(int $managementTypeId, User $user)
    {
        $manager = $this->getEntityManager();
        $managementType = $manager->getRepository(ManagementType::class)->find($managementTypeId);
        $query = $manager->createQuery(
            'SELECT t FROM App\Entity\RelUserManagementResource t
            WHERE t.user = :user
            AND t.managementType = :managementType'
        )
            ->setParameter('user', $user)
            ->setParameter('managementType', $managementType);

        return $this->putResourcesInTab($query->getResult());
    }

    /**
     * @return array
     */
    public function getSharedResources(User $user)
    {
        $manager = $this->getEntityManager();
        $query = $manager->createQuery(
            'SELECT t FROM App\Entity\RelSharedResourceUser t
                WHERE t.sharedWithUser = :user'
        )
            ->setParameter('user', $user);

        return $this->putResourcesInTab($query->getResult());
    }

    /**
     * @return array
     */
    public function getResourcesByActionType(int $actionTypeId, User $user)
    {
        $manager = $this->getEntityManager();
        $actionType = $manager->getRepository(ActionType::class)->find($actionTypeId);
        $query = $manager->createQuery(
            'SELECT t FROM App\Entity\RelUserActionResource t
                WHERE t.user = :user
                AND t.actionType = :actionType'
        )
            ->setParameter('user', $user)
            ->setParameter('actionType', $actionType);

        return $this->putResourcesInTab($query->getResult());
    }

    /**
     * @param $result
     *
     * @return array
     */
    private function putResourcesInTab($result)
    {
        $resources = [];
        for ($i = 0; $i < count($result); ++$i) {
            $resources[$i] = $result[$i]->getResource();
        }

        return $resources;
    }
}
