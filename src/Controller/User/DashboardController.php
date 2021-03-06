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

class DashboardController extends AbstractController
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
     * @Route("/user_dashboard", name="user_dashboard")
     */
    public function index(): Response
    {
        $user = $this->getUser();

        if (isset($user)) {
            $favoris = $this->manager->getRepository(Resource::class)->getNumberOfResourceByManagementType(1, $user);
            $putAside = $this->manager->getRepository(Resource::class)->getNumberOfResourceByManagementType(2, $user);
            $exploited = $this->manager->getRepository(Resource::class)->getNumberOfResourceByManagementType(3, $user);
            $shared = $this->manager->getRepository(Resource::class)->getNumberOfSharedResource($user);
            $consulted = $this->manager->getRepository(Resource::class)->getNumberOfResourceByActionType(2, $user);
            $created = $this->manager->getRepository(Resource::class)->getNumberOfResourceByActionType(1, $user);
            $commented = $this->manager->getRepository(Comment::class)->getNumberOfComments($user);

            return $this->render('user/dashboard.html.twig', [
                'favoris' => $favoris,
                'putAside' => $putAside,
                'exploited' => $exploited,
                'shared' => $shared,
                'consulted' => $consulted,
                'created' => $created,
                'commented' => $commented,
            ]);
        } else {
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/user_dashboard/edit_user", name="user_dashboard_edit_user")
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

                return $this->redirectToRoute('user_dashboard');
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
     * @Route("user_dashboard/resource/{resourceGestion}", name="user_resource")
     * @param string $resourceGestion
     * @return Response
     */
    public function userResources(string $resourceGestion): Response
    {
        $user = $this->getUser();

        if (isset($user)) {
            $favoris = $this->manager->getRepository(Resource::class)->getNumberOfResourceByManagementType(1, $user);
            $putAside = $this->manager->getRepository(Resource::class)->getNumberOfResourceByManagementType(2, $user);
            $exploited = $this->manager->getRepository(Resource::class)->getNumberOfResourceByManagementType(3, $user);
            $shared = $this->manager->getRepository(Resource::class)->getNumberOfSharedResource($user);
            $consulted = $this->manager->getRepository(Resource::class)->getNumberOfResourceByActionType(2, $user);
            $created = $this->manager->getRepository(Resource::class)->getNumberOfResourceByActionType(1, $user);
            $commented = $this->manager->getRepository(Comment::class)->getNumberOfComments($user);

            switch ($resourceGestion) {
                case 'favoris':
                    $resources = $this->manager->getRepository(Resource::class)->getResourcesByManagementType(1, $user);
                    break;
                case 'putAside':
                    $resources = $this->manager->getRepository(Resource::class)->getResourcesByManagementType(2, $user);
                    break;
                case 'exploited':
                    $resources = $this->manager->getRepository(Resource::class)->getResourcesByManagementType(3, $user);
                    break;
                case 'shared':
                    $resources = $this->manager->getRepository(Resource::class)->getSharedResources($user);
                    break;
                case 'consulted':
                    $resources = $this->manager->getRepository(Resource::class)->getResourcesByActionType(2, $user);
                    break;
                case 'created':
                    $resources = $this->manager->getRepository(Resource::class)->getResourcesByActionType(1, $user);
                    break;
                default:
                    $resources = [];
            }

            return $this->render('user/user_resource.html.twig', [
                'resources' => $resources,
                'resourceGestion' => $resourceGestion,
                'favoris' => $favoris,
                'putAside' => $putAside,
                'exploited' => $exploited,
                'shared' => $shared,
                'consulted' => $consulted,
                'created' => $created,
                'commented' => $commented,
            ]);
        } else {
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route ("user_dashboard/change_password", name="change_password")
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
                    return $this->redirectToRoute('user_dashboard');
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
