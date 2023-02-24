<?php

namespace App\DataFixtures;

use App\Entity\Sponsor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SponsorFixtures extends Fixture
{
    public function __construct(
        private readonly HttpClientInterface $client
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->removeContentFolder();
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 7; $i++) {
            $sponsor = (new Sponsor())
                ->setName($faker->company)
                ->setLink($faker->url)
                ->setImage(md5(uniqid()) . '.jpg');

            $response = $this->client->request('GET', "https://s3-us-west-2.amazonaws.com/s.cdpn.io/557257/" . $i . ".png");
            $fileHandler = fopen('public/uploads/media/sponsors/content/' . $sponsor->getImage(), 'w');
            foreach ($this->client->stream($response) as $chunk) {
                fwrite($fileHandler, $chunk->getContent());
            }

            $manager->persist($sponsor);
        }

        $manager->flush();
    }

    private function removeContentFolder()
    {
        $dirname = 'public/uploads/media/sponsors/content';

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
