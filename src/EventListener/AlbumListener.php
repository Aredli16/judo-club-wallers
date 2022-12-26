<?php

namespace App\EventListener;

use App\Entity\Album;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class AlbumListener
{
    public function __construct(private readonly SluggerInterface $slugger)
    {
    }

    public function postPersist(Album $album, LifecycleEventArgs $event): void
    {
        $album->setSlug($this->slugger->slug($album->getTitle() . ' ' . (string)$album->getId())->lower());
        $event->getObjectManager()->persist($album);
        $event->getObjectManager()->flush();
    }
}