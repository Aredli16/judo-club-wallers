<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ContactControllerTest extends WebTestCase
{
    public function testResponseSucces(): void
    {
        $client = static::createClient();
        $client->request('GET', '/contact');

        $this->assertResponseIsSuccessful();
    }
    public function testNotEmpty():void{
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact');
        $this->assertNotEmpty($crawler);
    }
    public function testText():void{
        $client = static::createClient();
        $client->request('GET', '/contact');
        $this->assertSelectorTextContains('h1',"Formulaire de Contact");
    }
    public function testSend():void{
        $client = static::createClient();
        $crawler =$client->request('GET', '/contact');
        $form = $crawler->selectButton('Submit')->form([
            'contact_email[email]' => 'jean@gmail.com',
            'contact_email[subject]' => 'jean',
            'contact_email[message]' => 'jean du jardin',
        ]);
        $client->submit($form);
        $data = $form->getValues();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertEquals('jean@gmail.com',$data['contact_email[email]']);
        $this->assertEquals('jean',$data['contact_email[subject]']);
        $this->assertEquals('jean du jardin',$data['contact_email[message]']);
    }

}
