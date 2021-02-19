<?php

namespace App\Controller;

use App\Entity\ActionType;
use App\Entity\AgeCategory;
use App\Entity\Comment;
use App\Entity\Commentary;
use App\Entity\RelationshipType;
use App\Entity\RelUserActionResource;
use App\Entity\RelUserManagementResource;
use App\Entity\Resource;
use App\Form\CommentType;
use App\Form\ResourceType;
use App\Repository\ManagementTypeRepository;
use App\Repository\RelUserManagementResourceRepository;
use App\Repository\ResourceRepository;
use App\Search\FilterData;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/resources")
 */
class ResourceController extends AbstractController
{
    public const ROUTE_PREFIX = 'resources';

    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("", name="resources")
     */
    public function index(ManagerRegistry $registry, Request $request, ResourceRepository $resourceRepository, RelUserManagementResourceRepository $relUserManagementResourceRepository, PaginatorInterface $paginator): Response
    {
        $request->query->set('direction', 'desc');
        $resourceFav = [];
        if ($this->getUser()) {
            $resourceFav = $relUserManagementResourceRepository->getFavorite($this->getUser(), $registry);
        }
        $resourceSide = [];
        if ($this->getUser()) {
            $resourceSide = $relUserManagementResourceRepository->getSide($this->getUser(), $registry);
        }

        $search = $request->query->get('search');

        $filter = new FilterData();
        $formfilter = $this->createFormBuilder($filter, [
            'method' => 'GET',
            'csrf_protection' => false,
            'block_prefix' => null,])
            ->add('search', HiddenType::class, [
                'data' => $search,
            ])
            ->add('type', EntityType::class, [
                'required' => false,
                'class' => \App\Entity\ResourceType::class,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('relation', EntityType::class, [
                'required' => false,
                'class' => RelationshipType::class,
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('age', EntityType::class, [
                'required' => false,
                'class' => AgeCategory::class,
                'multiple' => true,
                'expanded' => true,
            ])
            ->getForm();
        $formfilter->handleRequest($request);

        $resources = $paginator->paginate(
            $resourceRepository->findPublicQuery($filter, $search, 'DESC'),
            $request->query->getInt('page', 1),
            12,
            array('defaultSortFieldName' => 'r.dateCreation', 'defaultSortDirection' => 'desc')
        );

        return $this->render(
            self::ROUTE_PREFIX . '/index.html.twig',
            [
                'resources' => $resources,
                'filter' => $formfilter->CreateView(),
                'resourceFav' => $resourceFav,
                'resourceSide' => $resourceSide,
            ]
        );
    }

    /**
     * @Route("/{slug}-{id}", name="comment.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Request $request, string $slug, int $id, ResourceRepository $resourceRepository, RelUserManagementResourceRepository $managementResourceRepository, ManagementTypeRepository $managementTypeRepository, EntityManagerInterface $entityManager): Response
    {
        $resource = $resourceRepository->find($id);

        //Management Type Favoris
        $FavmanagementType = $managementTypeRepository->findOneBy(['label' => 'favoris']);

        if ($this->getUser()) {
            $isfav = $managementResourceRepository->findOneBy([
                'user' => $this->getUser()->getId(),
                'resource' => $id,
                'managementType' => $FavmanagementType->getId(),
            ]);
        } else {
            $isfav = null;
        }

        //Management Type mis de côte
        $sideManagementType = $managementTypeRepository->findOneBy(['label' => 'Mis de côté']);

        if ($this->getUser()) {
            $isSide = $managementResourceRepository->findOneBy([
                'user' => $this->getUser()->getId(),
                'resource' => $id,
                'managementType' => $sideManagementType->getId(),
            ]);
        } else {
            $isSide = null;
        }
        $comment = new Comment();
        $commentary = new Commentary();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($request->request->get('commentary')) {
            $commentary
                ->setContent($request->request->get('commentary')['content'])
                ->setResource($resource)
                ->setUser($this->getUser());
            $entityManager->persist($commentary);
            $entityManager->flush();
        }
        if ($form->isSubmitted() && $form->isValid()) {
            if (null === $this->getUser()) {
                return $this->redirectToRoute('login');
            }

            $comment = $form->getData();

            $comment->setResource($resource);
            $comment->setUser($this->getUser());

            //dump($comment);die;
            $entityManager->persist($comment);
            $entityManager->flush();
        }

        return $this->render(self::ROUTE_PREFIX . '/show.html.twig', [
            'resource' => $resource,
            'current_menu' => 'resources',
            'form' => $this->createForm(CommentType::class, new Comment())->createView(),
            'isFavorite' => $isfav,
            'isSide' => $isSide,
        ]);
    }

    /**
     * @Route("comment/{id}/edit", name="comment.edit")
     *
     * @param int $commentId
     */
    public function editComment(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $comment = $entityManager->getRepository(Comment::class)->find($id);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('comment.show', [
                'slug' => $comment->getResource()->getSlug(),
                'id' => $comment->getResource()->getId(),
            ]);
        }

        return $this->render(self::ROUTE_PREFIX . '/editComment.html.twig', [
            'comment' => $comment,
            'current_menu' => 'resources',
            'resource' => $comment->getResource(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("comment/{id}/delete", name="comment.delete")
     */
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Comment::class)->find($id);
        $entityManager->remove($comment);
        $entityManager->flush();

        return $this->redirectToRoute('comment.show', [
            'slug' => $comment->getResource()->getSlug(),
            'id' => $comment->getResource()->getId(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit_resource")
     */
    public function edit(Resource $resource, Request $request): Response
    {
        $user = $this->getUser();

        if (isset($user)) {
            $form = $this->createForm(ResourceType::class, $resource);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->manager->flush();
                $this->addFlash('success', 'Les modifications ont été enregistrées');

                return $this->redirectToRoute('user_resource', [
                    'resourceGestion' => 'created',
                ]);
            }

            return $this->render('resources/create_edit.html.twig', [
                'resource' => $resource,
                'form' => $form->createView(),
                'type' => 'edit',
            ]);
        } else {
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/add", name="add_resource")
     */
    public function add(Request $request)
    {
        $user = $this->getUser();

        if (isset($user)) {
            $resource = new Resource();
            $resource->setUser($user);

            $form = $this->createForm(ResourceType::class, $resource);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $resource->setActive(false);
                $this->manager->persist($resource);

                //alimente la table de relation
                $actionType = $this->manager->getRepository(ActionType::class)->find(1);
                $relUserActionResource = new RelUserActionResource();
                $relUserActionResource
                    ->setUser($user)
                    ->setResource($resource)
                    ->setActionType($actionType)
                    ->setActionDate(new \DateTime('now'));
                $this->manager->persist($relUserActionResource);

                $this->manager->flush();
                $this->addFlash('success', 'La ressource a été créée');

                return $this->redirectToRoute('user_resource', [
                    'resourceGestion' => 'created',
                ]);
            }

            return $this->render('resources/create_edit.html.twig', [
                'resource' => $resource,
                'form' => $form->createView(),
                'type' => 'creation',
            ]);
        } else {
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/addRemoveFav", name="addRemoveFav")
     */
    public function addRemoveFav(Request $request, ResourceRepository $resourceRepository, RelUserManagementResourceRepository $managementResourceRepository, ManagementTypeRepository $managementTypeRepository, EntityManagerInterface $entityManager): Response
    {
        $url = $request->query->get('url');
        $id = $request->query->get('id');
        $resource = $resourceRepository->find($id);

        //Management Type Favoris
        $FavmanagementType = $managementTypeRepository->findOneBy(['label' => 'favoris']);

        $existingfav = $managementResourceRepository->findOneBy([
            'user' => $this->getUser()->getId(),
            'resource' => $id,
            'managementType' => $FavmanagementType->getId(),
        ]);
        if ($existingfav) {
            $entityManager->remove($existingfav);
            $entityManager->flush();
        } else {
            $newfav = new RelUserManagementResource();
            $newfav->setUser($this->getUser())
                ->setManagementType($FavmanagementType)
                ->setResource($resource);
            $entityManager->persist($newfav);
            $entityManager->flush();
        }

        return $this->redirect($url);
    }

    /**
     * @Route("/addRemoveSide", name="addRemoveSide")
     */
    public function addRemoveSide(Request $request, ResourceRepository $resourceRepository, RelUserManagementResourceRepository $managementResourceRepository, ManagementTypeRepository $managementTypeRepository, EntityManagerInterface $entityManager): Response
    {
        $url = $request->query->get('url');
        $id = $request->query->get('id');
        $resource = $resourceRepository->find($id);

        //Management Type mise de côte
        $SideManagementType = $managementTypeRepository->findOneBy(['label' => 'Mis de côté']);
        $existingSide = $managementResourceRepository->findOneBy([
            'user' => $this->getUser()->getId(),
            'resource' => $id,
            'managementType' => $SideManagementType->getId(),
        ]);
        if ($existingSide) {
            $entityManager->remove($existingSide);
            $entityManager->flush();
        } else {
            $newSide = new RelUserManagementResource();
            $newSide->setUser($this->getUser())
                ->setManagementType($SideManagementType)
                ->setResource($resource);
            $entityManager->persist($newSide);
            $entityManager->flush();
        }

        return $this->redirect($url);
    }
}
