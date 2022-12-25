<?php

namespace App\Tests;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();
        $this->userRepository = $kernel->getContainer()->get('doctrine')->getManager()->getRepository(User::class);
    }
    public function testInsertUser(): void
    {
        $users = count($this->userRepository->findAll());
        if($this->userRepository->findOneBy(['email' => 'test@email.com']) == null){
            $user = new User();
            $user->setFirstname('firstname');
            $user->setLastname('lastname');
            $user->setEmail('test@email.com');
            $user->setFirstname('firstname');
            $user->setPassword('pswd');
            $user->setPhoneNumber('000000');
            $this->userRepository->save($user, true);
            $this->assertEquals($users + 1, count($this->userRepository->findAll()));
        }else{
            $this->assertEquals($users, count($this->userRepository->findAll()));
        }
        
    }

    public function testDeleteUser(): void
    {
        $users = $this->userRepository->findAll();
        if(count($users)-1 >= 0){
            $this->userRepository->remove($users[rand(0, count($users)-1)], true);
            $this->assertEquals(count($users)-1, count($this->userRepository->findAll()));
        }else{
            $this->assertEquals(count($users), count($this->userRepository->findAll()));
        }
    }
}
