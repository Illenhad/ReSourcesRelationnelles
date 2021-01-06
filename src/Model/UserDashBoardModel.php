<?php

namespace App\Model;

use App\Entity\ActionType;
use App\Entity\ManagementType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserDashBoardModel
{
    /**
     * @param EntityManagerInterface $manager
     * @param int $managementTypeId
     * @param User $user
     * @return int
     */
    public function getNumberOfResourceByManagementType(EntityManagerInterface $manager, int $managementTypeId, User $user)
    {
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
    public function getNumberOfSharedResource(EntityManagerInterface $manager, User $user)
    {
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
    public function getNumberOfResourceByActionType(EntityManagerInterface $manager, int $actionTypeId, User $user)
    {
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
     * @param EntityManagerInterface $manager
     * @param User $user
     * @return mixed
     */
    public function getNumberOfComments(EntityManagerInterface $manager, User $user)
    {
        $query = $manager->createQuery(
            'SELECT COUNT(r) FROM App\Entity\Comment r
                WHERE r.user = :user'
        )
            ->setParameter('user', $user);

        return $query->getScalarResult()[0][1];
    }

    /**
     * @return int|mixed|string
     */
    public function getResourcesByManagementType(EntityManagerInterface $manager, int $managementTypeId, User $user)
    {
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
    public function getSharedResources(EntityManagerInterface $manager, User $user)
    {
        $query = $manager->createQuery(
            'SELECT t FROM App\Entity\RelSharedResourceUser t
                WHERE t.sharedWithUser = :user'
        )
            ->setParameter('user', $user);

        return $this->putResourcesInTab($query->getResult());
    }

    public function getResourcesByActionType(EntityManagerInterface $manager, int $actionTypeId, User $user)
    {
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

    private function putResourcesInTab($result)
    {
        $resources = [];
        for ($i = 0; $i < count($result); ++$i) {
            $resources[$i] = $result[$i]->getResource();
        }

        return $resources;
    }
}
