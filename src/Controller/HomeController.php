<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use App\Repository\ArticleRepository;
use App\Repository\SponsorRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(
        AlbumRepository   $albumRepository,
        ArticleRepository $articleRepository,
        UserRepository    $userRepository,
        SponsorRepository $sponsorRepository
    ): Response
    {
        $latestAlbum = $albumRepository->findLatestAlbum(6);
        $latestArticle = $articleRepository->findLatestArticles(3);
        $teachers = $userRepository->findByRole('ROLE_TEACHER');
        $sponsors = $sponsorRepository->findAll();

        return $this->render('home/index.html.twig', [
            'latestAlbum' => $latestAlbum,
            'latestArticle' => $latestArticle,
            'teachers' => $teachers,
            'sponsors' => $sponsors
        ]);
    }
}
