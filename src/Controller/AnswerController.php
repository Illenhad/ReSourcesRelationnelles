<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Commentary;
use App\Form\AnswerType;
use App\Form\CommentaryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("")
 */
class AnswerController extends AbstractController
{
    /**
     * @Route("/commentary/{commentary}/answer/new", name="answer_new", methods={"GET","POST"})
     */
    public function new(Request $request, Commentary $commentary): Response
    {
        if (null === $this->getUser()) {
            return $this->redirectToRoute('login');
        }
        $answer = new Answer();
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        $answer
            ->setAnswerDate(new \DateTime())
            ->setUser($this->getUser())
            ->setCommentary($commentary);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($answer);

            $entityManager->flush();

            return $this->redirectToRoute('comment.show', [
                'id' => $commentary->getResource()->getId(),
                'slug' => $commentary->getResource()->getSlug(),
            ]);
        }

        return $this->render('answer/new.html.twig', [
            'commentary' => $commentary,
            'answer' => $answer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/answer/{id}", name="answer_show", methods={"GET"})
     */
    public function show(Answer $answer): Response
    {
        return $this->render('answer/show.html.twig', [
            'answer' => $answer,
        ]);
    }

   /**
    * @Route("/answer/{id}/edit", name="answer_edit", methods={"GET","POST"})
    */
   public function edit(Request $request, Answer $answer): Response
   {
       $form = $this->createForm(AnswerType::class, $answer);
       $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($answer);
            $em->flush();

            return $this->redirectToRoute('comment.show', [
                'slug' => $answer->getCommentary()->getResource()->getSlug(),
                'id' => $answer->getCommentary()->getResource()->getId(),
            ]);
        }

        return $this->render('answer/edit.html.twig', [
            'answer' => $answer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/answer/{id}", name="answer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Answer $answer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$answer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($answer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('answer_index');
    }
}
