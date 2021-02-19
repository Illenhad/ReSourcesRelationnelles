<?php

namespace App\Controller;

use App\Entity\Commentary;
use App\Entity\Resource;
use App\Form\CommentaryType;
use App\Repository\CommentaryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("")
 */
class CommentaryController extends AbstractController
{
    /**
     * @Route("resources/{resource}/commentary/", name="commentary_index", methods={"GET"})
     */
    public function index(CommentaryRepository $commentaryRepository, Resource $resource): Response
    {
        return $this->render('commentary/index.html.twig', [
            'commentaries' => $commentaryRepository->findBy(['resource' => $resource]),
            'resource' => $resource,
        ]);
    }

    /**
     * @Route("resources/{resource}/commentary/new", name="commentary_new", methods={"GET","POST"})
     */
    public function new(Request $request, Resource $resource): Response
    {
        if (null === $this->getUser()) {
            return $this->redirectToRoute('login');
        }
        $commentary = new Commentary();
        $form = $this->createForm(CommentaryType::class, $commentary);
        $form->handleRequest($request);
        $commentary
            ->setCommentDate(new \DateTime())
            ->setUser($this->getUser())
            ->setResource($resource)
        ;
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentary);
            $entityManager->flush();

            return $this->redirectToRoute('commentary_index', [
                'resource' => $resource->getId(),
            ]);
        }

        return $this->render('commentary/new.html.twig', [
            'commentary' => $commentary,
            'resource' => $resource,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/commentary/{id}/edit", name="commentary_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commentary $commentary): Response
    {
        $form = $this->createForm(CommentaryType::class, $commentary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment.show', [
                'slug' => $commentary->getResource()->getSlug(),
                'id' => $commentary->getResource()->getId(),
            ]);
        }

        return $this->render('commentary/edit.html.twig', [
            'commentary' => $commentary,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/commentary/{id}", name="commentary_delete")
     */
    public function delete(Request $request, int $id, Commentary $commentary): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Commentary::class)->find($id);
        $entityManager->remove($commentary);
        $entityManager->flush();

        return $this->redirectToRoute('comment.show', [
            'slug' => $commentary->getResource()->getSlug(),
            'id' => $commentary->getResource()->getId(),
        ]);
    }
}
