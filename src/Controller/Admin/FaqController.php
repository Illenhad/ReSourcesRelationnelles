<?php

namespace App\Controller\Admin;

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
        return $this->redirect(
            'https://www.fichier-pdf.fr/2021/03/11/guide-utilisateur---administration-et-moderation/guide-utilisateur---administration-et-moderation.pdf'
    );
    }
}
