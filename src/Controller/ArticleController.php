<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    public function __construct(private readonly ArticleRepository $articleRepository)
    {
        
    }
    #[Route('/article', name: 'app_article', methods: ['GET'])]
    public function index(PaginatorInterface $paginatorInterface, Request $request): Response
    {   
        return $this->render('article/index.html.twig', [
            'articles' => $paginatorInterface->paginate(
                $this->articleRepository->findAll(),
                $request->query->getInt('page',1),
                1
            )
        ]);
    }

    #[Route('/article/{slug}', name: 'show.article', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/details.html.twig', [
            'article' => $article,
            'latest_articles' => $this->articleRepository->findThreeLatestArticles($article->getId())
        ]);
    }
}