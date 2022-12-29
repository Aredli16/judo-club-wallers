<?php

namespace App\Tests;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    private UserRepository $userRepository;
    private $client;

    public function setUp(): void
    {      
        parent::setUp();
        $this->client = static::createClient();
        $this->userRepository = $this->getContainer()->get('doctrine')->getManager()->getRepository(User::class);
    }

    public function testLoginWithBadCredentials(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
            'email' => 'test@email.com',
            'password' => 'fakepswd'
        ]);
        $this->client->submit($form);
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }

    public function testLoginWithValidCredentials(): void
    {
        if ($this->userRepository->findOneBy(['email' => 'coco@email.com']) == null) {
            $user = new User();
            $user->setFirstname('firstname');
            $user->setLastname('lastname');
            $user->setEmail('coco@email.com');
            $user->setFirstname('firstname');
            $user->setPassword('$2y$10$cLczLi2.Ym8bj4sKaiNJS.rS3czJSswj9Ez2r2sCXo07R/l3E1Cl.');
            $user->setPhoneNumber('0102030405');
            $this->userRepository->save($user, true);
        }
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
            'email' => 'coco@email.com',
            'password' => '000000'
        ]);
        $this->client->submit($form);
        $this->assertResponseRedirects();
    }
}
