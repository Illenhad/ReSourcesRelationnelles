<?php

namespace App\Repository;

use App\Entity\RelUserActionResource;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RelUserActionResource|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelUserActionResource|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelUserActionResource[]    findAll()
 * @method RelUserActionResource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelUserActionResourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelUserActionResource::class);
    }

    /**
     * @return int
     */
    public function getResourceToValidateNumber() : int {

        $connexion = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT DISTINCT resource_id FROM rel_user_action_resource 
            WHERE id NOT IN (
                SELECT resource_id FROM rel_user_action_resource 
                WHERE action_type_id = :actionTypeId
            )';

        try {
            $statement = $connexion->prepare($sql);
            $statement->execute(['actionTypeId' => 3]);
            return $statement->rowCount();
        } catch (Exception $e) {
            return -1;
        } catch (\Doctrine\DBAL\Driver\Exception $e) {
            return -1;
        }
    }

    public function getCurrentDayResourcesConsultedNumber() {

        $manager = $this->getEntityManager();

        $query = $manager->createQuery('
            SELECT count(r)
            FROM App\Entity\RelUserActionResource r
            WHERE r.actionDate BETWEEN :date1 AND :date2
        ')-> setParameter('date1', new DateTime('today'))
        ->setParameter('date2', new DateTime('now'));

        return $query->getScalarResult()[0][1];
    }

    // /**
    //  * @return RelUserActionResource[] Returns an array of RelUse    rActionResource objects
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
    public function findOneBySomeField($value): ?RelUserActionResource
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
