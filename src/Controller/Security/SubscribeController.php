<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\SubscribeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscribeController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     * @Route("/subscribe", name="subscribe")
     */
    public function index(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(SubscribeType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid())
        {
            $entity_manager=$this->getDoctrine()->getManager();
            $entity_manager->persist($user);
            $entity_manager->flush();
        }

        return $this->render('security/subscribe.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
