<?php

namespace App\Controller\User;

use App\Form\EditPersonalInformationType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\UserDashBoardModel;

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

            $model = new UserDashBoardModel();
            $favoris = $model->getNumberOfResourceByManagementType($this->manager, 1, $user);
            $putAside = $model->getNumberOfResourceByManagementType($this->manager, 2, $user);
            $exploited = $model->getNumberOfResourceByManagementType($this->manager, 3, $user);
            $shared = $model->getNumberOfSharedResource($this->manager, $user);
            $consulted = $model->getNumberOfResourceByActionType($this->manager,2, $user);
            $created = $model->getNumberOfResourceByActionType($this->manager, 1, $user);
            $commented = $model->getNumberOfComments($this->manager, $user);

            return $this->render('user/dashboard.html.twig', [
                'favoris' => $favoris,
                'putAside' => $putAside,
                'exploited' => $exploited,
                'shared' => $shared,
                'consulted' =>$consulted,
                'created' => $created,
                'commented' => $commented
            ]);
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

    /**
     * @param string $resourceGestion
     * @return Response
     * @Route("user_dashboard/resource/{resourceGestion}", name="user_resource")
     */
    public function userResources(string $resourceGestion): Response {
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
                'resourceGestion' => $resourceGestion
            ]);
        } else {
            return $this->redirectToRoute('login');
        }
    }
}