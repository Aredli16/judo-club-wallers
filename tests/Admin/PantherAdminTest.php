<?php

namespace App\Tests;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Facebook\WebDriver\WebDriverBy;
use Symfony\Component\Panther\PantherTestCase;

class PantherAdminTest extends PantherTestCase
{
    private ArticleRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();

        $this->repository = $kernel->getContainer()->get('doctrine')->getManager()->getRepository(Article::class);
    }
    public function testLoginWithValidAdminCredentials(): void
    {
        $client = static::createPantherClient(array_replace(static::$defaultOptions, ['port' => 9081]));
        $crawler = $client->request('GET', '/login');
        $client->waitFor("#submit");
        $button = $client->getWebDriver()->findElement(WebDriverBy::id("submit"));
        $client->getWebDriver()->findElement(WebDriverBy::id("inputEmail"))->sendKeys("admin@admin.com");
        $client->getWebDriver()->findElement(WebDriverBy::id("inputPassword"))->sendKeys("admin");
        $button->click();
        $client->waitFor('html');
        $url = $client->getCurrentURL();
        $route = explode('/', $url);
        $this->assertEquals("admin", end($route));
    }

    public function testLoginWithUnvalidCredentials(): void
    {

        $client = static::createPantherClient(array_replace(static::$defaultOptions, ['port' => 9081]));
        $crawler = $client->request('GET', '/login');
        $client->waitFor("#submit");
        $button = $client->getWebDriver()->findElement(WebDriverBy::id("submit"));
        $client->getWebDriver()->findElement(WebDriverBy::id("inputEmail"))->sendKeys("admin@admin.com");
        $client->getWebDriver()->findElement(WebDriverBy::id("inputPassword"))->sendKeys("NonValidPassword");
        $button->click();
        $client->waitFor('html');
        $this->assertSelectorTextContains('div', 'Invalid credentials.');
    }

    public function testAddArticleInAdminDashboard(): void
    {
        $nbArticles = count($this->repository->findAll());
        $client = static::createPantherClient(array_replace(static::$defaultOptions, ['port' => 9081]));
        $crawler = $client->request('GET', '/login');
        $client->waitFor("#submit");
        $button = $client->getWebDriver()->findElement(WebDriverBy::id("submit"));
        $client->getWebDriver()->findElement(WebDriverBy::id("inputEmail"))->sendKeys("admin@admin.com");
        $client->getWebDriver()->findElement(WebDriverBy::id("inputPassword"))->sendKeys("admin");
        $button->click();
        $client->waitFor('html');
        $client->getWebDriver()->findElement(WebDriverBy::id('navigation-toggler'))->click();
        $client->waitForVisibility('#main-menu > ul > li:nth-child(2) > a');
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('#main-menu > ul > li:nth-child(2) > a'))->click();
        $client->waitFor('html');
        $client->getWebDriver()->findElement(WebDriverBy::className('btn'))->click();
        $client->waitFor('html');
        $client->getWebDriver()->findElement(WebDriverBy::id('Article_title'))->sendKeys("Panther Test Title");
        $client->getWebDriver()->findElement(WebDriverBy::className('trix-content'))->sendKeys("Panther Test Desc");
        $client->getWebDriver()->findElement(WebDriverBy::className('btn'))->click();
        $newNbArticles = count($this->repository->findAll());
        $this->assertEquals($nbArticles+1, $newNbArticles);
    }
}
