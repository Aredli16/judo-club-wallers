<?php

namespace App\Tests\Admin\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AlbumCrudControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private UserRepository $userRepository;
    private User $userTest;

    public function testAlbumCrudResponseSuccessful(): void
    {
        $this->client->loginUser($this->userTest);
        $this->client->request('GET', '/admin?crudAction=index&crudControllerFqcn=App\Controller\Admin\AlbumCrudController');

        $this->assertResponseIsSuccessful();
    }

    public function testAlbumCrudResponseAccessDeniedIfNotAdmin()
    {
        $this->userTest->setRoles([]);

        $this->client->loginUser($this->userTest);
        $this->client->request('GET', '/admin?crudAction=index&crudControllerFqcn=App\Controller\Admin\AlbumCrudController');

        $this->assertResponseStatusCodeSame(403);
    }

    public function testAlbumCrudResponseRedirectIfNotLogged()
    {
        $this->client->request('GET', '/admin?crudAction=index&crudControllerFqcn=App\Controller\Admin\AlbumCrudController');

        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertRouteSame('app_login');
    }

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
        $this->userTest = (new User())
            ->setLastname('Test')
            ->setFirstname('Test')
            ->setEmail('test@email.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('Test');
        $this->userRepository->save($this->userTest, true);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->userRepository->remove($this->userRepository->find($this->userTest->getId()), true);
    }
}
