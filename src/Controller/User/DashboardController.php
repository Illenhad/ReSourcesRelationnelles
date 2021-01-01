<?php

namespace App\Controller\User;

use App\Form\EditPersonalInformationType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController {

    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager) {

        $this->manager = $manager;
    }

    /**
     * @return Response
     * @Route("/user_dashboard", name="user_dashboard")
     */
    public function index(): Response
    {
        $user = $this->getUser();

        if (isset($user)) {
            return $this->render('user/dashboard.html.twig');
        } else {
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/user_dashboard/edit_user", name="user_dashboard_edit_user")
     */
    public function editPersonalInformation(Request $request): Response
    {
        $user = $this->getUser();

        if (isset($user)) {
            $form = $this->createForm(EditPersonalInformationType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->manager->flush();
                $this->addFlash('success', 'Les modifications ont été enregistrées');
                return $this->redirectToRoute('user_dashboard');
            }

            return $this->render('user/edit_personal_info.html.twig', [
                'user' => $user,
                'form' => $form->createView()
            ]);
        } else {
            return $this->redirectToRoute('login');
        }
    }
}