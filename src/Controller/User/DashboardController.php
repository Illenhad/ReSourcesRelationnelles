<?php

namespace App\Controller\User;

use App\Form\ChangePasswordType;
use App\Form\EditPersonalInformationType;
use App\Model\ChangePasswordModel;
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
            $model = new UserDashBoardModel();
            $favoris = $model->getNumberOfResourceByManagementType($this->manager, 1, $user);
            $putAside = $model->getNumberOfResourceByManagementType($this->manager, 2, $user);
            $exploited = $model->getNumberOfResourceByManagementType($this->manager, 3, $user);
            $shared = $model->getNumberOfSharedResource($this->manager, $user);
            $consulted = $model->getNumberOfResourceByActionType($this->manager, 2, $user);
            $created = $model->getNumberOfResourceByActionType($this->manager, 1, $user);
            $commented = $model->getNumberOfComments($this->manager, $user);

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
            $model = new UserDashBoardModel();

            switch ($resourceGestion) {
                case 'favoris':
                    $resources = $model->getResourcesByManagementType($this->manager, 1, $user);
                    break;
                case 'putAside':
                    $resources = $model->getResourcesByManagementType($this->manager, 2, $user);
                    break;
                case 'exploited':
                    $resources = $model->getResourcesByManagementType($this->manager, 3, $user);
                    break;
                case 'shared':
                    $resources = $model->getSharedResources($this->manager, $user);
                    break;
                case 'consulted':
                    $resources = $model->getResourcesByActionType($this->manager, 2, $user);
                    break;
                case 'created':
                    $resources = $model->getResourcesByActionType($this->manager, 1, $user);
                    break;
                default:
                    $resources = [];
            }

            return $this->render('user/user_resource.html.twig', [
                'resources' => $resources,
                'resourceGestion' => $resourceGestion,
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

                $model = new ChangePasswordModel($this->passwordEncoder);
                $passwordUpdatedMessage = $model->changePassword($this->manager, $user->getUsername(), $form->getData());

                if ('' == $passwordUpdatedMessage) {
                    $this->addFlash('success', 'Le mot de passe a été modifié');
                    return $this->redirectToRoute('user_dashboard');
                } else {
                    $this->addFlash('error', $passwordUpdatedMessage);
                }
            }

            return $this->render('user/change_password.html.twig', [
                'form' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('login');
        }
    }
}
