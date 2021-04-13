<?php

namespace App\Controller\Gathering;

use App\Entity\GatheringInvite;
use App\Entity\Resource;
use App\Entity\ResourceGathering;
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

class GatheringController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $manager;
    public const ROUTE_PREFIX = 'gathering';

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/mes-group", name="gatherings")
     */
    public function index(ManagerRegistry $registry): Response
    {
        $user = $this->getUser();

        if (isset($user)) {
            $user_gatherings = $this->manager->getRepository(GatheringUser::class)->findBy(['User' => $user->getId()]);//getGroupsUserByUserId($user->getId(), $registry);
            $gatherings = [];
            foreach($user_gatherings as $user_gathering) {
                $gathering = [];
                $gathering_admin = $this->manager->getRepository(GatheringUser::class)->findOneBy(['Gathering' => $user_gathering->getGathering(), 'role' => 'ADMIN']);
                $gathering_admin_name = $this->manager->getRepository(User::class)->findOneBy(['id' => $gathering_admin->getUser()])->getUsername();
                $gathering_user_num = $this->manager->getRepository(GatheringUser::class)->getGatheringNumMembersByGatheringId($user_gathering->getGathering()->getId(), $registry);
                $gathering[] = [
                    'gathering_id' => $user_gathering->getGathering()->getId(),
                    'name' => $user_gathering->getGathering()->getName(),
                    'admin' => $gathering_admin_name,
                    'num_members' => $gathering_user_num,
                    'role' => $user_gathering->getRole()
                ];
                $gatherings[] = $gathering;
            }
            return $this->render('gathering/dashboard.html.twig', [
                'gatheringGestion' => 'gatherings',
                'gatherings' => $gatherings,
            ]);
        } else {
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/group-{gathering_id}/remove-member-{member_id}", name="gathering-remove-member")
     */
    public function removeMember(int $gathering_id, int $member_id, ManagerRegistry $registry) {
        $gathering_user = $this->manager->getRepository(GatheringUser::class)->findOneBy(['Gathering' => $gathering_id, 'User' => $member_id]);
        $this->manager->remove($gathering_user);
        $this->manager->flush();

        if($member_id != $this->getUser()->getId()) {
            return $this->redirectToRoute('gathering.show', ['id' => $gathering_id]);
        }
        return $this->redirectToRoute('gatherings');
    }

    /**
     * @Route("/group-{id}/inviter", name="gathering-invit-user", methods={"GET","POST"})
     */
    public function invitUser(int $id, Request $request) {
        $gathering = $this->manager->getRepository(Gathering::class)->findOneBy(['id' => $id]);
        $user = $this->getUser();

        $gatheringInvite = new GatheringInvite();
        $form = $this->createForm(GatheringInviteType::class, $gatheringInvite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $invited = $this->manager->getRepository(User::class)->findOneBy(['email' => $form["mail"]->getData()]);
            $gatheringInvite
                ->setInviting($user)
                ->setInvited($invited)
                ->setGathering($gathering);

            $this->manager->persist($gatheringInvite);

            $this->manager->flush();
            $this->addFlash('success', 'L\'invitation a été créée');

            return $this->redirectToRoute('gathering.show', ['id' => $id]);
        }

        return $this->render('gathering_invite/create.html.twig', [
            'gatheringGestion' => 'invite',
            'gathering_id' => $id,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/group-{id}", name="gathering.show")
     */
    public function show(int $id, ManagerRegistry $registry): Response {
        $user = $this->getUser();
        $gathering = $this->manager->getRepository(Gathering::class)->find($id);
        $gathering_users = $this->manager->getRepository(GatheringUser::class)->findBy(['Gathering' => $id]);
        $user_role = $this->manager->getRepository(GatheringUser::class)->findOneBy(['Gathering' => $id, 'User' => $user->getId()])->getRole();
        $members = [];
        foreach ($gathering_users as $gathering_user) {
            $member = [
                'user_id' => $this->manager->getRepository(User::class)->findOneBy(['id' => $gathering_user->getUser()])->getId(),
                'user_name' => $this->manager->getRepository(User::class)->findOneBy(['id' => $gathering_user->getUser()])->getUsername(),
                'user_role' => $gathering_user->getRole()
            ];
            $members[] = $member;
        }

        return $this->render(self::ROUTE_PREFIX.'/show.html.twig', [
            'gatheringGestion' => 'show',
            'is_admin' => ($user_role == 'ADMIN') ? true : false,
            'gathering' => $gathering,
            'current_menu' => '$gathering',
            'members' => $members
        ]);
    }

    /**
     * @Route("/creer-un-groupe", name="gathering-add")
     */
    public function add(Request $request) {
        $user = $this->getUser();
        $gathering = new Gathering();
        $form = $this->createForm(GatheringType::class, $gathering);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($gathering);

            $gatheringUser = new GatheringUser();
            $gatheringUser
                ->setUser($user)
                ->setRole('ADMIN')
                ->setGathering($gathering);

            $this->manager->persist($gatheringUser);

            $this->manager->flush();
            $this->addFlash('success', 'Le groupe a été créé');

            return $this->redirectToRoute('gatherings');
        }

        return $this->render('gathering/create_edit.html.twig', [
            'gathering' => $gathering,
            'form' => $form->createView(),
            'type' => 'creation',
        ]);
    }

    /**
     * @Route("/group-{id}/ressources", name="gathering-resources")
     */
    public function resources(int $id, ManagerRegistry $registry): Response {
        $user = $this->getUser();
        $gathering = $this->manager->getRepository(Gathering::class)->find($id);


        $gathering_resources = $this->manager->getRepository(ResourceGathering::class)->findBy(['gathering' => $id]);
        $user_role = $this->manager->getRepository(GatheringUser::class)->findOneBy(['Gathering' => $id, 'User' => $user->getId()])->getRole();
        ($user_role == 'ADMIN') ? $isAdmin = true : $isAdmin = false;
        $resources = [];
        foreach ($gathering_resources as $gathering_resource) {
            $resourceG = $this->manager->getRepository(Resource::class)->findOneBy(['id' => $gathering_resource->getResource()]);
            $sharing = $this->manager->getRepository(User::class)->findOneBy(['id' => $gathering_resource->getSharingUser()]);
            ($sharing == $user) ? $isSharing = true : $isSharing = false;
            $resource = [
                'gatheringGestion' => 'resources',
                'title' => $resourceG->getTitle(),
                'id' => $resourceG->getId(),
                'slug' => $resourceG->getSlug(),
                'sharing' => $sharing->getUsername(),
                'is_sharing' => $isSharing
            ];
            $resources[] = $resource;
        }

        return $this->render(self::ROUTE_PREFIX.'/resources.html.twig', [
            'gatheringGestion' => 'resources',
            'resources' => $resources,
            'gathering_id' => $gathering->getId(),
            'is_admin' => $isAdmin
        ]);
    }

    /**
     * @Route("/group-{id}/remove-remove-{resource_id}", name="gathering-remove-resource")
     */
    public function removeResource(int $id, int $resource_id, ManagerRegistry $registry) {
        $gathering_resource = $this->manager->getRepository(ResourceGathering::class)->findOneBy(['gathering' => $id, 'resource' => $resource_id]);

        $this->manager->remove($gathering_resource);

        $this->manager->flush();
        return $this->redirectToRoute('gathering-resources', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/group-{id}/remove", name="gathering-remove")
     */
    public function removeGathering(int $id, ManagerRegistry $registry) {
        $user = $this->getUser();
        $gathering = $this->manager->getRepository(Gathering::class)->findOneBy(['id' => $id]);
        $gatheringAdmin = $this->manager->getRepository(GatheringUser::class)->findOneBy(['Gathering' => $id, 'role' => 'ADMIN']);

        if($user != $gatheringAdmin->getUser()) {
            return $this->redirectToRoute('gatherings');
        }
        $gathering_resources = $this->manager->getRepository(ResourceGathering::class)->findBy(['gathering' => $id]);
        foreach ($gathering_resources as $gathering_resource) {
            $this->manager->remove($gathering_resource);
        }
        $gathering_users = $this->manager->getRepository(GatheringUser::class)->findBy(['Gathering' => $id]);
        foreach ($gathering_users as $gathering_user) {
            $this->manager->remove($gathering_user);
        }
        $this->manager->remove($gathering);
        $this->manager->flush();
        return $this->redirectToRoute('gatherings');
    }
}
