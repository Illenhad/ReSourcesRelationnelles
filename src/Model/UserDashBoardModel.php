<?php

namespace App\Model;

use App\Entity\ActionType;
use App\Entity\ManagementType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserDashBoardModel {

    /**
     * @param EntityManagerInterface $manager
     * @param int $managementTypeId
     * @param User $user
     * @return int
     */
    public function getNumberOfResourceByManagementType(EntityManagerInterface $manager, int $managementTypeId, User $user) {
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
     * @param EntityManagerInterface $manager
     * @param User $user
     * @return mixed
     */
    public function getNumberOfSharedResource(EntityManagerInterface $manager, User $user) {
        $query = $manager->createQuery(
            'SELECT COUNT(r) FROM App\Entity\RelSharedResourceUser r
                WHERE r.sharedWithUser = :user'
        )
            ->setParameter('user', $user);
        return $query->getScalarResult()[0][1];
    }

    /**
     * @param EntityManagerInterface $manager
     * @param int $actionTypeId
     * @param User $user
     * @return mixed
     */
    public function getNumberOfResourceByActionType(EntityManagerInterface $manager, int $actionTypeId, User $user) {
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

    public function getNumberOfComments(EntityManagerInterface $manager, User $user) {
        $query = $manager->createQuery(
            'SELECT COUNT(r) FROM App\Entity\Comment r
                WHERE r.user = :user'
        )
            ->setParameter('user', $user);
        return $query->getScalarResult()[0][1];
    }
}