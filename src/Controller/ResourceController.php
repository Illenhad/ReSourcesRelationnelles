<?php

namespace App\Controller;

use App\Repository\ResourceRepository;
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
     * @Route("")
     *
     * @return Response
     */
    public function index(Request $request, ResourceRepository $resourceRepository, PaginatorInterface $paginator)
    {
        $resources = $paginator->paginate(
            $resourceRepository->findPublicQuery('ASC'),
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
}
