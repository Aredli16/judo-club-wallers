<?php

namespace App\Tests\Admin\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleCrudControllerTest extends WebTestCase
{
    public function testArticleCrudResponseSuccessful(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin?crudAction=index&crudControllerFqcn=App\Controller\Admin\ArticleCrudController');

        $this->assertResponseIsSuccessful();
    }
}
