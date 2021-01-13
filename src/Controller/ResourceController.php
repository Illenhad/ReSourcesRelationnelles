<?php

namespace App\Controller;

use App\Entity\ActionType;
use App\Entity\AgeCategory;
use App\Entity\Comment;
use App\Entity\RelationshipType;
use App\Entity\RelUserActionResource;
use App\Entity\Resource;
use App\Form\CommentType;
use App\Form\ResourceType;
use App\Repository\ResourceRepository;
use App\Search\FilterData;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     *
     * @return Response
     */
    public function index(Request $request, Request $request2, ResourceRepository $resourceRepository, PaginatorInterface $paginator)
    {
        $search = $request->query->get('search');

        $filter = new FilterData();
        $formfilter = $this->createFormBuilder($filter, [
            'method' => 'GET',
            'csrf_protection' => false,
            'block_prefix' => null, ])
            ->add('type', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => \App\Entity\ResourceType::class,
                'multiple' => true,
                'attr' => ['class' => 'selectTags', 'name' => 'type'],
            ])
            ->add('relation', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => RelationshipType::class,
                'multiple' => true,
                'attr' => ['class' => 'selectTags', 'name' => 'relationship'],
                ])
            ->add('age', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => AgeCategory::class,
                'multiple' => true,
                'attr' => ['class' => 'selectTags', 'name' => 'age'],
                ])
            ->getForm()
        ;
        $formfilter->handleRequest($request);

        $resources = $paginator->paginate(
            $resourceRepository->findPublicQuery($filter, $search, 'DESC'),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render(
            self::ROUTE_PREFIX.'/index.html.twig',
            [
                'resources' => $resources,
                'filter' => $formfilter->CreateView(),
            ]
        );
    }

    /**
     * @Route("/{slug}-{id}", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Request $request, string $slug, int $id, ResourceRepository $resourceRepository, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();
        $resource = $resourceRepository->find($id);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (null === $this->getUser()) {
                return $this->redirectToRoute('login');
            }

            $comment = $form->getData();

            $comment->setResource($resource);
            $comment->setUser($this->getUser());

            $entityManager->persist($comment);
            $entityManager->flush();
        }

        return $this->render(self::ROUTE_PREFIX.'/show.html.twig', [
            'resource' => $resource,
            'current_menu' => 'resources',
            'form' => $form->createView(),
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
     * @Route("/{slug}", name="resource")
     */
    public function showComments($slug)
    {
        $resource = $this->getDoctrine()->getRepository(Resource::class)->findOneBy(['slug' => $slug]);

        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy([
            'resources' => $resource,
        ], ['created_at' => 'desc']);

        if (!$resource) {
            throw $this->createNotFoundException('L\'article n\'existe pas');
        }

        return $this->render('show.html.twig', compact('resource', 'comments'));
    }
}
