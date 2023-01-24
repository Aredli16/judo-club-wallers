<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @codeCoverageIgnore
 */
class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly HttpClientInterface         $client
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $this->removeContentFolder(); // Remove all image in public/uploads/media/users/content
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
                ->setAvatar(md5(uniqid()) . '.jpg')
                ->setAbout($faker->text)
                ->setRoles(['ROLE_TEACHER']);
            $user->setPassword($this->hasher->hashPassword($user, $user->getPassword()));


            $response = $this->client->request('GET', 'https://thispersondoesnotexist.com/image');
            $fileHandler = fopen('public/uploads/media/users/content/' . $user->getAvatar(), 'w');
            foreach ($this->client->stream($response) as $chunk) {
                fwrite($fileHandler, $chunk->getContent());
            }

            $manager->persist($user);
        }

        $manager->flush();
    }

    private function removeContentFolder()
    {
        $dirname = 'public/uploads/media/users/content';

        if (is_dir($dirname)) {
            $files = glob($dirname . '/*');

            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        } else {
            mkdir($dirname, recursive: true);
        }
    }
}
