<?php

namespace App\Controller;

use App\Entity\Gathering;
use App\Entity\GatheringInvite;
use App\Entity\GatheringUser;
use App\Entity\ResourceGathering;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\GatheringRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    protected $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    protected function setDashboardMenu(string $gatheringGestion = 'gatherings', Gathering $gathering = null): array
    {
        $user = $this->getUser();
        $dashboardCounts = [
            'gatherings' => $this->manager->getRepository(GatheringUser::class)->getNumberOfGatheringUserByUser($user),
            'invites' => $this->manager->getRepository(GatheringInvite::class)->getNumberOfGatheringInvitByUser($user)
        ];
        if (!in_array($gatheringGestion, ['gatherings', 'invites']) ) {
            $dashboardCounts['resources'] = $this->manager->getRepository(ResourceGathering::class)->getNumberOfGatheringResourceByGathering($gathering);
        }
        return $dashboardCounts;
    }

}
