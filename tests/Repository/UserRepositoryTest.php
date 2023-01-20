<?php

namespace App\Tests\Repository;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\InMemoryUser;

class UserRepositoryTest extends KernelTestCase
{
    public function testInsertUser(): void
    {
        $users = count($this->userRepository->findAll());

        $user = (new User())
            ->setFirstname('firstname')
            ->setLastname('lastname')
            ->setEmail('test@email.com')
            ->setFirstname('firstname')
            ->setPassword('pswd')
            ->setPhoneNumber('000000')
            ->setRoles(['ROLE_ADMIN']);
        $this->userRepository->save($user, true);

        $this->assertCount($users + 1, $this->userRepository->findAll());
    }

    public function testUpgradePassword(): void
    {
        /** @var User $user */
        $user = $this->userRepository->findAll()[0];
        $oldPassword = $user->getPassword();

        $this->userRepository->upgradePassword($user, 'newHashedPassword');

        /** @var User $user */
        $user = $this->userRepository->findAll()[0];
        $this->assertNotEquals($oldPassword, $user->getPassword());
        $this->assertEquals('newHashedPassword', $user->getPassword());
    }

    public function testUpgradePasswordThrowExceptionIfNotUserInstance(): void
    {
        $this->expectException(UnsupportedUserException::class);

        $this->userRepository->upgradePassword(new InMemoryUser('test', 'test'), 'Test');
    }

    public function testFindByRole(): void
    {
        $admins = $this->userRepository->findByRole('ROLE_ADMIN');

        /** @var User $admin */
        foreach ($admins as $admin) {
            $this->assertContains('ROLE_ADMIN', $admin->getRoles());
        }
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
