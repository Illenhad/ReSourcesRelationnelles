<?php

namespace App\Controller\Gathering;

use App\Entity\GatheringInvite;
use App\Entity\User;
use App\Entity\Gathering;
use App\Entity\GatheringUser;
use App\Form\GatheringInviteType;
use App\Form\GatheringType;
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

class GatheringInviteController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/mes-invitations", name="gathering_invites")
     */
    public function index(ManagerRegistry $registry): Response
    {
        $user = $this->getUser();

        if (isset($user)) {
            $invites = $this->manager->getRepository(GatheringInvite::class)->findBy(['invited' => $user->getId()]);

            return $this->render('gathering_invite/dashboard.html.twig', [
                'gatheringGestion' => 'invites',
                'invites' => $invites,
            ]);
        } else {
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/invitation-{id}/{agree}", name="accept_invite")
     */
    public function acceptInvite(int $id, string $agree, ManagerRegistry $registry): Response
    {
        $user = $this->getUser();

        if (isset($user)) {
            $invite = $this->manager->getRepository(GatheringInvite::class)->findOneBy(['id' => $id]);
            if ($agree == 'agree') {
                $gatheringUser = new GatheringUser();
                $gatheringUser
                    ->setUser($user)
                    ->setRole('MEMBER')
                    ->setGathering($invite->getGathering());

                $this->manager->persist($gatheringUser);

                $this->manager->remove($invite);

                $this->manager->flush();
                $this->addFlash('success', 'Invitation acceptée');
            } else {
                $this->manager->remove($invite);
                $this->manager->flush();
                $this->addFlash('success', 'Invitation refusée');
            }
            return $this->redirectToRoute('gathering_invites');
        } else {
            return $this->redirectToRoute('login');
        }
    }
}
