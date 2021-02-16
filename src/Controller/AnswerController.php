<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Commentary;
use App\Form\AnswerType;
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
     * @Route("/answer/{id}", name="answer_delete")
     */
    public function delete(Request $request, int $id, Answer $answer): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $answer = $entityManager->getRepository(Answer::class)->find($id);
        $entityManager->remove($answer);
        $entityManager->flush();

        return $this->redirectToRoute('comment.show', [
            'slug' => $answer->getCommentary()->getResource()->getSlug(),
            'id' => $answer->getCommentary()->getResource()->getId(),
        ]);
    }
}
