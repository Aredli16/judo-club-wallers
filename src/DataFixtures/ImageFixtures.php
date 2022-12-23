<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @codeCoverageIgnore
 */
class ImageFixtures extends Fixture
{
    const GENERATE_IMAGE = AlbumFixtures::GENERATE_ALBUM * 3;

    public function __construct(private readonly HttpClientInterface $client)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function load(ObjectManager $manager): void
    {
        // Remove all image into upload/media/images folder
        $this->removeImageFolder();

        for ($i = 0; $i <= self::GENERATE_IMAGE; $i++) {
            /** @noinspection PhpParamsInspection */
            $photo = (new Image())
                ->setName(md5(uniqid()) . '.jpg')
                ->setAlbum($this->getReference(rand(0, AlbumFixtures::GENERATE_ALBUM) . '-album'));

            $response = $this->client->request('GET', 'https://picsum.photos/200');
            $fileHandler = fopen('public/uploads/media/images/' . $photo->getName(), 'w');
            foreach ($this->client->stream($response) as $chunk) {
                fwrite($fileHandler, $chunk->getContent());
            }

            $manager->persist($photo);
        }
        $manager->flush();
    }

    private function removeImageFolder()
    {
        $files = glob('public/uploads/media/images/*');

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}
