<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'show.articles')]
    public function showArticles(ManagerRegistry $doctrine): Response
    {
        $articles = $doctrine->getRepository(Article::class)->findAll();
        return $this->render('articles/index.html.twig', ['articles' => $articles]);
    }

    #[Route('/article/{id}', name: 'show.article')]
    public function showArticle(ManagerRegistry $doctrine, $id): Response
    {
        $article = $doctrine->getRepository(Article::class)->find($id);
        return $this->render('article/index.html.twig', ['article' => $article]);
    }

}
