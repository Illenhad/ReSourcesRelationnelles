<?php

namespace App\Repository;

use App\Entity\GatheringInvite;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GatheringInvite|null find($id, $lockMode = null, $lockVersion = null)
 * @method GatheringInvite|null findOneBy(array $criteria, array $orderBy = null)
 * @method GatheringInvite[]    findAll()
 * @method GatheringInvite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GatheringInviteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GatheringInvite::class);
    }

    /**
     * @return int
     */
    public function getNumberOfGatheringInvitByUser(User $user)
    {
        $query = $this->createQueryBuilder('gi')
            ->select('count(gi.id)')
            ->andWhere('gi.invited = :invited')
            ->setParameter('invited', $user);
        return $query->getQuery()->getSingleScalarResult();
    }
}
