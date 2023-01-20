<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @codeCoverageIgnore
 */
class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Admin user
        $user = (new User())
            ->setEmail('admin@admin.com')
            ->setPassword('admin')
            ->setLastname($faker->lastName)
            ->setFirstname($faker->firstName)
            ->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->hasher->hashPassword($user, $user->getPassword()));
        $manager->persist($user);

        // Teacher user
        for ($i = 0; $i < 5; $i++) {
            $user = (new User())
                ->setEmail('teacher' . $i . '@teacher.com')
                ->setPassword('teacher')
                ->setLastname($faker->lastName)
                ->setFirstname($faker->firstName)
                ->setAbout($faker->text)
                ->setRoles(['ROLE_TEACHER']);
            $user->setPassword($this->hasher->hashPassword($user, $user->getPassword()));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
