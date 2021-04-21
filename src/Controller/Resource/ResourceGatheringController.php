<?php

namespace App\Controller\Resource;

use App\Entity\Gathering;
use App\Entity\GatheringUser;
use App\Entity\Resource;
use App\Entity\ResourceGathering;
use App\Entity\User;
use App\Form\ResourceGatheringType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/resource-gathering")
 */
class ResourceGatheringController extends AbstractController
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
     * @Route("/ressource/{id}/partage-groupe", name="resource-share-gathering", methods={"GET","POST"})
     *
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function shareToGathering(int $id, Request $request) {
        $resource = $this->manager->getRepository(Resource::class)->findOneBy(['id' => $id]);
        $user = $this->getUser();

        $choices = [];
        $userGatherings = $this->manager->getRepository(GatheringUser::class)->findBy(['User' => $user->getId()]);
        if (is_null($userGatherings) or empty($userGatherings)) {

            $this->addFlash('error', 'Vous n\'avez pas de groupe');

            return $this->redirectToRoute('comment.show', [
                'slug' => $resource->getSlug(),
                'id' => $resource->getId(),
            ]);
        } else {
            foreach ($userGatherings as $userGathering) {
                $gatheringU = $this->manager->getRepository(Gathering::class)->findOneBy(['id' => $userGathering->getGathering()]);
                $choices[$gatheringU->getName()] = $gatheringU->getId();
            }
        }

        $resourceGathering = new ResourceGathering();
        $form = $this->createForm(ResourceGatheringType::class, $resourceGathering, ['trait_choices' => $choices]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $gathering = $this->manager->getRepository(Gathering::class)->findOneBy(['id' => $form["gathering_id"]->getData()]);

//            $share = $this->manager->getRepository(ResourceGathering::class)->findOneBy(['resource' => $resource->getId(), 'gathering' => $gathering->getId()]);
//            if($share) {
//                $this->addFlash('error', 'La ressource est déjà partagée au groupe');
//            } else {
                $resourceGathering
                    ->setSharingUser($user)
                    ->setGathering($gathering)
                    ->setResource($resource);

                $this->addFlash('success', 'La ressource a été partagée au groupe');
//            }
            $this->manager->persist($resourceGathering);
            $this->manager->flush();
            return $this->redirectToRoute('comment.show', [
                'slug' => $resource->getSlug(),
                'id' => $resource->getId(),
            ]);

        }

        return $this->render('resources/share/create_gathering.html.twig', [
            'resource' => $resource,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/partage-{id}/{agree}", name="accept_resource_share")
     *
     * @param int $id
     * @param string $agree
     * @param ManagerRegistry $registry
     * @return Response
     */
    public function acceptShare(int $id, string $agree, ManagerRegistry $registry): Response
    {
        $user = $this->getUser();

        if (isset($user)) {
            $share = $this->manager->getRepository(ResourceShareUser::class)->findOneBy(['id' => $id]);
            if ($agree == 'agree') {
                $resourceUser = new ResourceUser();
                $resourceUser
                    ->setResource($share->getResource())
                    ->setSharedUser($share->getShared())
                    ->setSharingUser($share->getSharing());

                $this->manager->persist($resourceUser);

                $this->addFlash('success', 'Partage acceptée');
            } else {
                $this->addFlash('success', 'Partage refusée');
            }
            $this->manager->remove($share);
            $this->manager->flush();
            return $this->redirectToRoute('resources_dashboard', ['resourceGestion' => 'waiting']);
        } else {
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/annuler-partage-{id}", name="remove_user_resource")
     *
     * @param int $id
     * @return Response
     */
    public function removeShare(int $id): Response
    {
        $user = $this->getUser();
        if (isset($user)) {
            $share = $this->manager->getRepository(ResourceUser::class)->findOneBy(['id' => $id]);
            $this->manager->remove($share);
            $this->manager->flush();
            $this->addFlash('success', 'Partage supprimé');
            return $this->redirectToRoute('resources_dashboard', ['resourceGestion' => 'shared']);
        } else {
            return $this->redirectToRoute('login');
        }
    }
}
