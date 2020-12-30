<?php

namespace App\Controller\Security;

use App\Entity\Role;
use App\Entity\User;
use App\Form\SubscribeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SubscribeController extends AbstractController
{
    /**
     * @param UserPasswordEncoderInterface $encoder
     * @param Request $request
     * @return Response
     * @Route("/subscribe", name="subscribe")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder ): Response
    {
        $user = new User();
        $form = $this->createForm(SubscribeType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid())
        {
            //encodage du password
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);

            //definition du role
            $role = $this->getDoctrine()
                ->getRepository(Role::class)
                ->findOneBy(['label'=>'ROLE_USER']);
            $user->setRole($role);
            $entity_manager=$this->getDoctrine()->getManager();
            $entity_manager->persist($user);
            $entity_manager->flush();
            return $this->redirectToRoute('login');
        }

        return $this->render('security/subscribe.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
