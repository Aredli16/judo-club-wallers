<?php

namespace App\Controller\RGPD;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TermsOfUseController extends AbstractController
{
    #[Route('terms_of_use', name: 'app_terms_of_use')]
    public function index(): Response
    {
        return $this->render('rgpd/terms_of_use/index.html.twig', [
            'controller_name' => 'TermsOfUseController',
        ]);
    }
}
