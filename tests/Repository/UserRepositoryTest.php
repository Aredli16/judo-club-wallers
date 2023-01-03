<?php

namespace App\Tests\Repository;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    public function testInsertUser(): void
    {
        $users = count($this->userRepository->findAll());

        $user = new User();
        $user->setFirstname('firstname');
        $user->setLastname('lastname');
        $user->setEmail('test@email.com');
        $user->setFirstname('firstname');
        $user->setPassword('pswd');
        $user->setPhoneNumber('000000');
        $this->userRepository->save($user, true);

        $this->assertCount($users + 1, $this->userRepository->findAll());
    }

    public function testDeleteUser(): void
    {
        $users = $this->userRepository->findAll();
        $this->userRepository->remove($users[rand(0, count($users) - 1)], true);

        $this->assertCount(count($users) - 1, $this->userRepository->findAll());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();
        $this->userRepository = $kernel->getContainer()->get('doctrine')->getManager()->getRepository(User::class);
    }
}
