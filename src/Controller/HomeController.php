<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(AlbumRepository $albumRepository, ArticleRepository $articleRepository): Response
    {
        $latestAlbum = $albumRepository->findLatestAlbum(3);
        $latestArticle = $articleRepository->findLatestArticles(3);

        return $this->render('home/index.html.twig', [
            'latestAlbum' => $latestAlbum,
            'latestArticle' => $latestArticle
        ]);
    }
}
