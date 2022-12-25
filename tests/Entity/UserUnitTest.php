<?php

namespace App\Tests;

use App\Entity\User;
use \DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $user = new User();
        $user->setFirstname('firstname');
        $this->assertEquals('firstname', $user->getFirstname());
        $user->setLastname('lastname');
        $this->assertEquals('lastname', $user->getLastname());
        $user->setEmail('test@email.com');
        $this->assertEquals('test@email.com', $user->getEmail());
        $user->setFirstname('firstname');
        $this->assertEquals('firstname', $user->getFirstname());
        $user->setRoles(['ROLE_TEST']);
        $this->assertEquals(['ROLE_TEST', 'ROLE_USER'], $user->getRoles());
        $user->setPassword('pswd');
        $this->assertEquals('pswd', $user->getPassword());
        $user->setAvatar('avatar');
        $this->assertEquals('avatar', $user->getAvatar());
        $user->setPhoneNumber('000000');
        $this->assertEquals('000000', $user->getPhoneNumber());
        $user->setCreatedAt(new DateTimeImmutable('2020-01-01'));
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

    }

    public function testIsNotEmpty(): void
    {
        $user = new User();
        $this->assertNotEmpty($user->getCreatedAt());
        $this->assertNotEmpty($user->getAvatar());
        $this->assertNotEmpty($user->getRoles());
    }
}
