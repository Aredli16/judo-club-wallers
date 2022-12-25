<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AlbumControllerTest extends WebTestCase
{
    public function testShouldDisplayAlbumList(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/album');

        $this->assertResponseIsSuccessful();
    }
}
