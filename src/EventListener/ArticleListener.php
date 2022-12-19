<?php namespace App\EventListener;

use App\Entity\Article;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleListener
{
    public function __construct(private readonly SluggerInterface $slugger)
    {
        
    }
    
    public function postPersist(LifecycleEventArgs $args): void
    {  
        $entity = $args->getObject();
        if (!$entity instanceof Article) {
            return;
        }
        $entity->setSlug($this->slugger->slug($entity->getTitle() . " " . (string) $entity->getId())->lower());
        $entityManager = $args->getObjectManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }
}
?>