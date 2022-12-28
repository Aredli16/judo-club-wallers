<?php

namespace App\Tests\Admin\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AlbumCrudControllerTest extends WebTestCase
{
    public function testAlbumCrudResponseSuccessful(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin?crudAction=index&crudControllerFqcn=App\Controller\Admin\AlbumCrudController');

        $this->assertResponseIsSuccessful();
    }
}
