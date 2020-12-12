<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**

     * @return Response
     * @Route("/login", name="login")
     */
    public function index( ): Response
    {
       return $this->render('security/login.html.twig');
    }
}