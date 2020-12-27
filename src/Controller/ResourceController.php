<?php

namespace App\Controller;

use App\Entity\ActionType;
use App\Entity\RelUserActionResource;
use App\Entity\Resource;
use App\Form\ResourceType;
use App\Entity\Comment;
use App\Repository\ResourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
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
     * @Route("")
     *
     * @return Response
     */
    public function index(Request $request, ResourceRepository $resourceRepository, PaginatorInterface $paginator)
    {
        $resources = $paginator->paginate(
            $resourceRepository->findPublicQuery('DESC'),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render(self::ROUTE_PREFIX.'/index.html.twig',
            [
                'resources' => $resources,
            ]
        );
    }

    /**
     * @Route("/{slug}-{id}", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(string $slug, int $id, ResourceRepository $resourceRepository): Response
    {
        $resource = $resourceRepository->find($id);

        return $this->render(self::ROUTE_PREFIX.'/show.html.twig', [
            'resource' => $resource,
            'current_menu' => 'resources',
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit_resource")
     * @param Resource $resource
     * @param Request $request
     * @return Response
     */
    public function edit(Resource $resource, Request $request): Response {
        $user = $this->getUser();

        if (isset($user)) {
            $form = $this->createForm(ResourceType::class, $resource);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->manager->flush();
                $this->addFlash('success', 'Les modifications ont été enregistrées');

                return $this->redirectToRoute('user_resource', [
                    'resourceGestion' => 'created'
                ]);
            }

            return $this->render('resources/create_edit.html.twig', [
                'resource' => $resource,
                'form' => $form->createView(),
                'type' => 'edit'
            ]);
        } else {
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/add", name="add_resource")
     * @param Request $request
     */
    public function add(Request $request) {
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
                    'resourceGestion' => 'created'
                ]);
            }

            return $this->render('resources/create_edit.html.twig', [
                'resource' => $resource,
                'form' => $form->createView(),
                'type' => 'creation'
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
