<?php

namespace App\DataFixtures;

use App\Entity\Album;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * @codeCoverageIgnore
 */
class AlbumFixtures extends Fixture
{
    const GENERATE_ALBUM = 5;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i <= self::GENERATE_ALBUM; $i++) {
            $album = new Album();
            $album->setTitle($faker->sentence(2));
            $album->setMetadesc($faker->realText());
            $this->setReference($i . '-album', $album);
            $manager->persist($album);
        }
        $manager->flush();
    }
}
