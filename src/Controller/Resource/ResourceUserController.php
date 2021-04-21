<?php

namespace App\Controller\Resource;

use App\Entity\Resource;
use App\Entity\ResourceShareUser;
use App\Entity\ResourceUser;
use App\Entity\User;
use App\Form\ResourceShareUserType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/resource-user")
 */
class ResourceUserController extends AbstractController
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
     * @Route("/resource/{id}/partager-a-un-utilisateur", name="resource-share-user", methods={"GET","POST"})
     *
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function shareToUser(int $id, Request $request) {
        $resource = $this->manager->getRepository(Resource::class)->findOneBy(['id' => $id]);
        $user = $this->getUser();

        $resourceShare = new ResourceShareUser();
        $form = $this->createForm(ResourceShareUserType::class, $resourceShare);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $shared = $this->manager->getRepository(User::class)->findOneBy(['email' => $form["mail"]->getData()]);

            $share = $this->manager->getRepository(ResourceUser::class)->findOneBy(['resource' => $resource->getId(), 'user' => $shared->getId()]);
            if($share) {
                $this->addFlash('error', 'La ressource est déjà partagée à utilisateur');
            } else {
                $waiting = $this->manager->getRepository(ResourceShareUser::class)->findOneBy(['resource' => $resource->getId(), 'shared' => $shared->getId()]);
                if($waiting) {
                    $this->addFlash('error', 'L\'utilisateur à déjà une demande de partage en attente');
                } else {
                    $resourceShare
                        ->setSharing($user)
                        ->setShared($shared)
                        ->setResource($resource);
                    $this->manager->persist($resourceShare);
                    $this->manager->flush();
                    $this->addFlash('success', 'La demande de partage a été créée');

                    return $this->redirectToRoute('comment.show', [
                        'slug' => $resource->getSlug(),
                        'id' => $resource->getId(),
                    ]);
                }
            }

        }

        return $this->render('resources/share/create_user.html.twig', [
            'resource' => $resource,
            'form' => $form->createView()
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
