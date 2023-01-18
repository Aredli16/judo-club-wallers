<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @codeCoverageIgnore
 */
class ArticleFixtures extends Fixture
{
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
        $this->removeContentFolder(); // Remove all image into uploads/media/articles/content folder
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence(2));
            $article->setContent($faker->realText());
            $article->setAuthor($faker->firstName());

            // Image upload
            $article->setImageFileName(md5(uniqid()) . '.jpg');
            $response = $this->client->request('GET', 'https://picsum.photos/1920/1080');
            $fileHandler = fopen('public/uploads/media/articles/content/' . $article->getImageFileName(), 'w');
            foreach ($this->client->stream($response) as $chunk) {
                fwrite($fileHandler, $chunk->getContent());
            }

            $manager->persist($article);
        }
        $manager->flush();
    }

    private function removeContentFolder()
    {
        $files = glob('public/uploads/media/articles/content/*');

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}