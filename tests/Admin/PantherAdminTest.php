<?php

namespace App\Tests;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Facebook\WebDriver\WebDriverBy;
use Symfony\Component\Panther\PantherTestCase;

class PantherAdminTest extends PantherTestCase
{
    private ArticleRepository $articleRepository;
    private UserRepository $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();

        $this->articleRepository = $kernel->getContainer()->get('doctrine')->getManager()->getRepository(Article::class);
        $this->userRepository = $kernel->getContainer()->get('doctrine')->getManager()->getRepository(User::class);
    }

    public function loginToAdminPanel($client, $mail, $psw): void{
        $crawler = $client->request('GET', '/login');
        $client->waitFor("#submit");
        $button = $client->getWebDriver()->findElement(WebDriverBy::id("submit"));
        $client->getWebDriver()->findElement(WebDriverBy::id("inputEmail"))->sendKeys($mail);
        $client->getWebDriver()->findElement(WebDriverBy::id("inputPassword"))->sendKeys($psw);
        $button->click();
        $client->waitFor('html');
    }
    public function testLoginWithValidAdminCredentials(): void
    {        
        $client = static::createPantherClient(array_replace(static::$defaultOptions, ['port' => 9081]));
        $this->loginToAdminPanel($client, "admin@admin.com", "admin");
        $url = $client->getCurrentURL();
        $route = explode('/', $url);
        $this->assertEquals("admin", end($route));
    }

    public function testLoginWithUnvalidCredentials(): void
    {
        $client = static::createPantherClient(array_replace(static::$defaultOptions, ['port' => 9081]));
        $this->loginToAdminPanel($client, "admin@admin.com", "fakePsw");
        $this->assertSelectorTextContains('div', 'Invalid credentials.');
    }

    public function testAddArticleInAdminDashboard(): void
    {
        $nbArticles = count($this->articleRepository->findAll());
        $client = static::createPantherClient(array_replace(static::$defaultOptions, ['port' => 9081]));
        $this->loginToAdminPanel($client, "admin@admin.com", "admin");
        $client->getWebDriver()->findElement(WebDriverBy::id('navigation-toggler'))->click();
        $client->waitForVisibility('#main-menu > ul > li:nth-child(2) > a');
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('#main-menu > ul > li:nth-child(2) > a'))->click();
        $client->waitFor('html');
        $client->getWebDriver()->findElement(WebDriverBy::className('btn'))->click();
        $client->waitFor('html');
        $client->getWebDriver()->findElement(WebDriverBy::id('Article_title'))->sendKeys("Panther Test Title");
        $client->getWebDriver()->findElement(WebDriverBy::className('trix-content'))->sendKeys("Panther Test Desc");
        $client->getWebDriver()->findElement(WebDriverBy::className('btn'))->click();
        $newNbArticles = count($this->articleRepository->findAll());
        sleep(2);
        $this->assertEquals($nbArticles+1, $newNbArticles);
    }

    public function testAddUserInAdminDashboard(): void
    {
        $nbUser = count($this->userRepository->findAll());
        $client = static::createPantherClient(array_replace(static::$defaultOptions, ['port' => 9081]));
        $this->loginToAdminPanel($client, "admin@admin.com", "admin");
        $client->getWebDriver()->findElement(WebDriverBy::id('navigation-toggler'))->click();
        $client->waitForVisibility('#main-menu > ul > li:nth-child(5) > a');
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('#main-menu > ul > li:nth-child(5) > a'))->click();
        $client->waitFor('html');
        $client->getWebDriver()->findElement(WebDriverBy::className('btn'))->click();
        $client->waitFor('html');
        $client->getWebDriver()->findElement(WebDriverBy::id('User_email'))->sendKeys("panther@panther.com");
        $client->getWebDriver()->findElement(WebDriverBy::id('User_password'))->sendKeys("panther");
        $client->getWebDriver()->findElement(WebDriverBy::id('User_lastname'))->sendKeys("panther last name");
        $client->getWebDriver()->findElement(WebDriverBy::id('User_firstname'))->sendKeys("panther first name");
        $client->getWebDriver()->findElement(WebDriverBy::id('User_phoneNumber'))->sendKeys("0123456789");
        $client->getWebDriver()->findElement(WebDriverBy::id('User_about'))->sendKeys("panther about");
        $client->getWebDriver()->findElement(WebDriverBy::className('items-placeholder'))->click();
        $client->waitForVisibility('#User_roles-opt-2');
        $client->getWebDriver()->findElement(WebDriverBy::id('User_roles-opt-2'))->click();
        $client->getWebDriver()->findElement(WebDriverBy::className('action-saveAndReturn'))->click();
        $newNbUser = count($this->userRepository->findAll());
        $this->assertEquals($nbUser+1, $newNbUser);
    }
}
