<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterLinkController extends AbstractController
{
    /**
     * @Route("/accessibilite", name="accessibilite")
     */
    public function accessibilite(): Response
    {
        return $this->render('footer_link/accessibilite.html.twig', [
            'controller_name' => 'FooterLinkController',
        ]);
    }

    /**
     * @Route("/legal", name="legal")
     */
    public function legal(): Response
    {
        return $this->render('footer_link/Legal.html.twig', [
            'controller_name' => 'FooterLinkController',
        ]);
    }

    /**
     * @Route("/donnees-personnelles-et-cookies", name="RGPD")
     */
    public function rgpd(): Response
    {
        return $this->render('footer_link/RGPD.html.twig', [
            'controller_name' => 'FooterLinkController',
        ]);
    }
}
