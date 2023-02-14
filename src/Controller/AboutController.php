<?php

namespace App\Controller;

use App\Repository\SponsorRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route('/about', name: 'app_about')]
    public function index(
        UserRepository    $userRepository,
        SponsorRepository $sponsorRepository
    ): Response
    {
        $teachers = $userRepository->findByRole('ROLE_TEACHER');
        $sponsors = $sponsorRepository->findAll();

        return $this->render('about/index.html.twig', [
            'teachers' => $teachers,
            'sponsors' => $sponsors
        ]);
    }
}
