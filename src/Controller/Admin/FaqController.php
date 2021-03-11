<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\AgeCategoryRepository;
use App\Repository\DepartementRepository;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FaqController extends AbstractController
{
    /**
     * @Route("/faq", name="faq")
     *
     * @throws Exception
     */
    public function index(): Response
    {
        return $this->render('bundles/EasyAdminBundle/page/faq.html.twig', [

        ]);
    }


}
