<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'show.articles', methods: ['GET'])]
    public function showArticles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        return $this->render('articles/index.html.twig', ['articles' => $articles]);
    }

    #[Route('/article/{slug}', name: 'show.article', methods: ['GET'])]
    public function showArticle(Article $article): Response
    {
        return $this->render('articles/show.html.twig', ['article' => $article]);
    }

    #[Route('/article/{slug}', name: 'delete.article', methods: ['POST'])]
    public function deleteArticle(Article $article, ArticleRepository $articleRepository): Response
    {
        $articleRepository->remove($article, true);
        return $this->redirectToRoute('show.articles', []);
    }

    #[Route('/{slug}/edit', name: 'edit.article', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->save($article, true);
            return $this->redirectToRoute('show.articles', []);
        }

        return $this->renderForm('articles/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'new.article', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticleRepository $articleRepository): Response{
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setTitle($form->get('title')->getData());
            $article->setContent($form->get('content')->getData());
            $article->setImage($form->get('image')->getData());
            $article->setAuthor($form->get('author')->getData());
            $articleRepository->save($article, true);
            return $this->redirectToRoute('show.articles', []);
        }

        return $this->renderForm('articles/new.html.twig', [
            'form' => $form
        ]);
    }
}
