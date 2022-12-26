<?php

namespace App\EventListener;

use App\Entity\Article;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleListener
{
    public function __construct(private readonly SluggerInterface $slugger)
    {

    }

    public function postPersist(Article $article, LifecycleEventArgs $args): void
    {
        $article->setSlug($this->slugger->slug($article->getTitle() . " " . $article->getId())->lower());
        $args->getObjectManager()->getRepository(Article::class)->save($article, true);
    }
}