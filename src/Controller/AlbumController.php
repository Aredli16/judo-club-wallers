<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends AbstractController
{
    public function __construct(
        private readonly AlbumRepository $albumRepository
    )
    {
    }

    #[Route('/album', name: 'app_album')]
    public function index(): Response
    {
        $albums = $this->albumRepository->findAll();

        return $this->render('album/index.html.twig', [
            'albums' => $albums
        ]);
    }
}
