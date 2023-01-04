<?php

namespace App\DataFixtures;

use App\Entity\AlbumContent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @codeCoverageIgnore
 */
class AlbumContentFixtures extends Fixture implements DependentFixtureInterface
{
    const FILE_CONTENT_GENERATED = AlbumFixtures::GENERATE_ALBUM * 3;

    public function __construct(
        private readonly HttpClientInterface $client
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function load(ObjectManager $manager): void
    {
        // Remove all image into uploads/media/albums/content folder
        $this->removeContentFolder();

        for ($i = 0; $i <= self::FILE_CONTENT_GENERATED; $i++) {
            /** @noinspection PhpParamsInspection */
            $content = (new AlbumContent())
                ->setFileName(md5(uniqid()) . '.jpg')
                ->setAlbum($this->getReference(rand(0, AlbumFixtures::GENERATE_ALBUM) . '-album'));

            $response = $this->client->request('GET', 'https://picsum.photos/200');
            $fileHandler = fopen('public/uploads/media/albums/content/' . $content->getFileName(), 'w');
            foreach ($this->client->stream($response) as $chunk) {
                fwrite($fileHandler, $chunk->getContent());
            }

            $manager->persist($content);
        }
        $manager->flush();
    }

    private function removeContentFolder()
    {
        $files = glob('public/uploads/media/albums/content/*');

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    public function getDependencies(): array
    {
        return [AlbumFixtures::class];
    }
}
