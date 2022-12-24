<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AlbumControllerTest extends WebTestCase
{
    public function testShouldDisplayArticleList(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article');

        $this->assertResponseIsSuccessful();
    }
}