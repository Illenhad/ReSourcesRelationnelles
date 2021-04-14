<?php

namespace App\Repository;

use App\Entity\Gathering;
use App\Entity\ResourceGathering;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResourceGathering|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResourceGathering|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResourceGathering[]    findAll()
 * @method ResourceGathering[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResourceGatheringRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResourceGathering::class);
    }

    /**
     * @return int
     */
    public function getNumberOfGatheringResourceByGathering(Gathering $gathering)
    {
        $query = $this->createQueryBuilder('rg')
            ->select('count(rg.id)')
            ->andWhere('rg.gathering = :gathering')
            ->setParameter('gathering', $gathering);
        return $query->getQuery()->getSingleScalarResult();
    }
}
