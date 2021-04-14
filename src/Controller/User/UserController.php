<?php

namespace App\Controller\User;

use App\Entity\Comment;
use App\Entity\Resource;
use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\EditPersonalInformationType;
use App\Model\UserDashBoardModel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $manager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->manager = $manager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/account", name="account")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        if (isset($user)) {
            return $this->render('user/account.html.twig');
        } else {
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/account/edit_user", name="account_edit")
     * @param Request $request
     * @return Response
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

                return $this->redirectToRoute('account');
            }

            return $this->render('user/edit_personal_info.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route ("account/change_password", name="change_password")
     * @param Request $request
     * @return Response
     */
    public function changePassword(Request $request): Response
    {
        $user = $this->getUser();

        if (isset($user)) {
            $form = $this->createForm(ChangePasswordType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $passwordUpdatedMessage = $this->manager->getRepository(User::class)->changePassword($user->getUsername(), $form->getData());

                if ('' == $passwordUpdatedMessage) {
                    $this->addFlash('success', 'Le mot de passe a été modifié');
                    return $this->redirectToRoute('account');
                } else {
                    $this->addFlash('error', $passwordUpdatedMessage);
                }
            }

            return $this->render('user/change_password.html.twig', [
                'form' => $form->createView()
            ]);
        } else {
            return $this->redirectToRoute('login');
        }
    }
}
