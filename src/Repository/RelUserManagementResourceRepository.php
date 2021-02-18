<?php

namespace App\Repository;

use App\Entity\RelUserManagementResource;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RelUserManagementResource|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelUserManagementResource|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelUserManagementResource[]    findAll()
 * @method RelUserManagementResource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelUserManagementResourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelUserManagementResource::class);
    }

    public function getFavorite(User $user, ManagerRegistry $registry)
    {
        $managementTypeRepository = new ManagementTypeRepository($registry);
        $favType = $managementTypeRepository->findOneBy(['label' => 'favoris']);
        $query = $this->createQueryBuilder('rel')
            ->select('res.id')
            ->join('rel.resource', 'res')
            ->andWhere('rel.user = :user')
            ->setParameter('user', $user->getId())
            ->andWhere('rel.managementType = :favType')
            ->setParameter('favType', $favType->getId())
        ;
        $rawlistFav = $query->getQuery()->getArrayResult();
        $listFav = [];
        foreach ($rawlistFav as $Fav) {
            array_push($listFav, $Fav['id']);
        }

        return $listFav;
    }

    public function getSide(User $user, ManagerRegistry $registry)
    {
        $managementTypeRepository = new ManagementTypeRepository($registry);
        $sidType = $managementTypeRepository->findOneBy(['label' => 'Mis de côté']);
        $query = $this->createQueryBuilder('rel')
            ->select('res.id')
            ->join('rel.resource', 'res')
            ->andWhere('rel.user = :user')
            ->setParameter('user', $user->getId())
            ->andWhere('rel.managementType = :sideType')
            ->setParameter('sideType', $sidType->getId())
        ;
        $rawlistSide = $query->getQuery()->getArrayResult();
        $listSide = [];
        foreach ($rawlistSide as $Side) {
            array_push($listSide, $Side['id']);
        }

        return $listSide;
    }


    // /**
    //  * @return RelUserManagementResourceFixture[] Returns an array of RelUserManagementResourceFixture objects
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
    public function findOneBySomeField($value): ?RelUserManagementResourceFixture
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
