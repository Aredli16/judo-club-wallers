<?php

namespace App\Tests\Repository;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArticleRepositoryTest extends KernelTestCase
{
    private ArticleRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();

        $this->repository = $kernel->getContainer()->get('doctrine')->getManager()->getRepository(Article::class);
    }

    public function testInsertValue()
    {
        $test = (new Article())
            ->setTitle("test_title")
            ->setContent("test_content")
            ->setAuthor("test_author")
            ->setImage("test_img")
            ->setSlug("test_slug");
        $this->repository->save($test, true);

        $this->assertEquals($test->getTitle(), $this->repository->find($test->getId())->getTitle());
        $this->assertEquals($test->getContent(), $this->repository->find($test->getId())->getContent());
        $this->assertEquals($test->getAuthor(), $this->repository->find($test->getId())->getAuthor());
        $this->assertEquals($test->getImage(), $this->repository->find($test->getId())->getImage());
        $this->assertEquals($test->getSlug(), $this->repository->find($test->getId())->getSlug());
    }

    public function testRemoveValue()
    {
        $articles = $this->repository->findAll();
        $nbArticles = count($articles);
        $this->repository->remove($articles[rand(0, $nbArticles - 1)], true);
        $articles = $this->repository->findAll();
        $this->assertCount($nbArticles - 1, $articles);
    }

    public function testASlugAfterPersist()
    {
        $test = (new Article())
            ->setTitle("test_title")
            ->setContent("test_content")
            ->setAuthor("test_author")
            ->setImage("test_img");
        $this->repository->save($test, true);

        $this->assertEquals('test-title-' . $test->getId(), $this->repository->find($test->getId())->getSlug());

        $this->repository->remove($test, true);
    }
}