<?php

namespace App\Controller;

use App\Entity\Resource;
use App\Repository\ResourceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/resource")
 */
class ResourceController extends AbstractController
{
    /**
     * @Route("")
     *
     * @param Request $request
     * @param ResourceRepository $resourceRepository
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, ResourceRepository $resourceRepository, PaginatorInterface $paginator)
    {
        $resources = $paginator->paginate(
            $resourceRepository->findPublicQuery('ASC'),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('resources/index.html.twig',
            [
                'resources' => $resources,
            ]
        );
    }
}
