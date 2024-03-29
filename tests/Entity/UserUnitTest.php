<?php

namespace App\Tests\Entity;

use App\Entity\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $user = (new User())
            ->setLastname('lastname')
            ->setFirstname('firstname')
            ->setEmail('test@email.com')
            ->setRoles(['ROLE_TEST'])
            ->setPassword('pswd')
            ->setAvatar('avatar')
            ->setPhoneNumber('000000')
            ->setAbout('about')
            ->setCreatedAt(new DateTimeImmutable('2020-01-01'));

        $this->assertEquals('lastname', $user->getLastname());
        $this->assertEquals('test@email.com', $user->getEmail());
        $this->assertEquals(['ROLE_TEST', 'ROLE_USER'], $user->getRoles());
        $this->assertEquals('firstname', $user->getFirstname());
        $this->assertEquals('pswd', $user->getPassword());
        $this->assertEquals('avatar', $user->getAvatar());
        $this->assertEquals('000000', $user->getPhoneNumber());
        $this->assertEquals('about', $user->getAbout());
        $this->assertEquals(new DateTimeImmutable('2020-01-01'), $user->getCreatedAt());
    }

    public function testUserFields(): void
    {
        $this->assertClassHasAttribute('id', User::class);
        $this->assertClassHasAttribute('firstname', User::class);
        $this->assertClassHasAttribute('lastname', User::class);
        $this->assertClassHasAttribute('email', User::class);
        $this->assertClassHasAttribute('roles', User::class);
        $this->assertClassHasAttribute('password', User::class);
        $this->assertClassHasAttribute('avatar', User::class);
        $this->assertClassHasAttribute('phone_number', User::class);
        $this->assertClassHasAttribute('about', User::class);
        $this->assertClassHasAttribute('created_at', User::class);
    }

    public function testIsEmpty(): void
    {
        $user = new User();
        $this->assertEmpty($user->getId());
        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getFirstname());
        $this->assertEmpty($user->getLastname());
        $this->assertEmpty($user->getPassword());
        $this->assertEmpty($user->getPhoneNumber());
        $this->assertEmpty($user->getAbout());
    }

    public function testIsNotEmpty(): void
    {
        $user = new User();
        $this->assertNotEmpty($user->getCreatedAt());
        $this->assertNotEmpty($user->getRoles());
    }
}
