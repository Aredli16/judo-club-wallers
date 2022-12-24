<?php

namespace App\Tests;

use App\DataFixtures\AppFixtures;
use App\Entity\Article;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleRepositoryTest extends KernelTestCase
{
    /**
     * @var AbstractDatabaseTool
     */
    protected $databaseTool;
    private $entityManager;

    public function setUp(): void
    {
        parent::setUp();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->entityManager = $this->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testNumberOfItems()
    {
        self::bootKernel();
        $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Article::class);
        $this->databaseTool->loadFixtures([
            AppFixtures::class
        ]);
        $nbArticles = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Article::class)->count([]);
        $this->assertEquals(10, $nbArticles);
    }

    public function testSearchByTitle()
    {
        self::bootKernel();
        $test = $this->entityManager->getRepository(Article::class)->findOneBy(['title' => 'Coco le petit fou']);
        $this->assertEquals(1, $test->getId());
    }

    public function testInsertValue(){
        self::bootKernel();
        $test = new Article();
        $test->setTitle("test_title");
        $test->setContent("test_content");
        $test->setAuthor("test_author");
        $test->setImage("test_img");
        $test->setSlug("test_slug");

        $this->entityManager->persist($test);
        $this->entityManager->flush();
        $this->assertEquals($test->getTitle(), $this->entityManager->getRepository(Article::class)->find($test->getId())->getTitle());
        $this->assertEquals($test->getContent(), $this->entityManager->getRepository(Article::class)->find($test->getId())->getContent());
        $this->assertEquals($test->getAuthor(), $this->entityManager->getRepository(Article::class)->find($test->getId())->getAuthor());
    }

    public function testRemoveValue(){
        self::bootKernel();
        $articles = $this->entityManager->getRepository(Article::class)->findAll();
        $nbArticles = count($articles);
        $this->entityManager->getRepository(Article::class)->remove($articles[rand(0, $nbArticles - 1)], true);
        $articles = $this->entityManager->getRepository(Article::class)->findAll();
        $this->assertEquals($nbArticles - 1, count($articles));
    }

    public function testPostPersist()
    {
        self::bootKernel();
        $test = $this->entityManager->getRepository(Article::class)->findOneBy(['title' => 'Coco le petit fou']);
        $this->assertEquals('coco-le-petit-fou-1', $test->getSlug());
    }

     protected function tearDown(): void
     {
         parent::tearDown();
         unset($this->databaseTool);
     }
}
?>