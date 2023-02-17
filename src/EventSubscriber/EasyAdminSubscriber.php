<?php

namespace App\EventSubscriber;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly HttpClientInterface   $httpClient,
        private readonly ParameterBagInterface $parameter
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['postToFacebook']
        ];
    }

    public function postToFacebook(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Article) {
            try {
                $this->httpClient->request(
                    'POST',
                    'https://graph.facebook.com/112297715116412/feed?message=' . strip_tags($entity->getContent()) . '&access_token=' . $this->parameter->get('facebook_access_token')
                );
            } catch (TransportExceptionInterface $e) {
                dd($e);
            }
        }
    }
}