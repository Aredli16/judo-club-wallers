<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly AlbumRepository $albumRepository
    )
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $lastAlbums = $this->albumRepository->findLastAlbum(3);

        return $this->render('home/index.html.twig', [
            'lastAlbums' => $lastAlbums
        ]);
    }
}
