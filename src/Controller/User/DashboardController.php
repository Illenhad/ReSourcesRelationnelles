<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController {

    /**
     * @param Request $request
     * @return Response
     * @Route("/user_dashboard", name="user_dashboard")
     */
    public function index(Request $request): Response
    {
        $user = $this->getUser();

        if (isset($user)) {
            return $this->render('user/dashboard.html.twig');
        } else {
            $pathInfo = $request->getPathInfo();
            $url = str_replace($pathInfo, rtrim($pathInfo, ' /'), 'login');
            return $this->redirect($url);
        }
    }
}