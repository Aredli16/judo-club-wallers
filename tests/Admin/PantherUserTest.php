<?php

namespace App\Tests;
use Facebook\WebDriver\WebDriverBy;
use Symfony\Component\Panther\PantherTestCase;

class PantherUserTest extends PantherTestCase
{
    public function testUserCanConsultSchedule(){
        $client = static::createPantherClient(array_replace(static::$defaultOptions, ['port' => 9081]));
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector("body > header > nav > div > ul > li:nth-child(2) > a"))->click();
        $client->waitFor('html');
        $this->assertSelectorTextContains('body > main > section:nth-child(2) > h2', 'HORAIRES');
    }

    public function testUserCanConsultLocation(){
        $client = static::createPantherClient(array_replace(static::$defaultOptions, ['port' => 9081]));
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector("body > header > nav > div > ul > li:nth-child(5) > a"))->click();
        $client->waitFor('html');
        $this->assertSelectorIsVisible('iframe');
    }

    public function testUserCanConsultMembers(){
        $client = static::createPantherClient(array_replace(static::$defaultOptions, ['port' => 9081]));
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector("body > header > nav > div > ul > li:nth-child(2) > a"))->click();
        $client->waitFor('html');
        $this->assertSelectorTextContains('body > main > section:nth-child(4) > h2', 'LES MEMBRES DU BUREAU');
    }

    public function testUserCanSeeLatestArticles(){
        $client = static::createPantherClient(array_replace(static::$defaultOptions, ['port' => 9081]));
        $this->assertSelectorExists('body > main > section:nth-child(5) > div > a:nth-child(1)');
    }

    public function testUserCanConsultAlbum(){
        $client = static::createPantherClient(array_replace(static::$defaultOptions, ['port' => 9081]));
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('body > header > nav > div > ul > li:nth-child(4) > a'))->click();
        $client->waitFor('html');
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('body > main > section.container > div > a:nth-child(1)'))->click();
        $client->waitFor('html');
        $this->assertSelectorExists('img');
    }

    public function testUserCanContactAnAdmin(){
        $client = static::createPantherClient(array_replace(static::$defaultOptions, ['port' => 9081]));
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('body > header > nav > div > ul > li:nth-child(5) > a'))->click();
        $client->waitFor('html');
        $client->getWebDriver()->findElement(WebDriverBy::id('contact_email'))->sendKeys('panther@panther.com');
        $client->getWebDriver()->findElement(WebDriverBy::id('contact_subject'))->sendKeys('panther test subject');
        $client->getWebDriver()->findElement(WebDriverBy::id('contact_message'))->sendKeys('panther test message');
        $client->getWebDriver()->findElement(WebDriverBy::id('contact_message'))->sendKeys('panther test message');
        $client->getWebDriver()->findElement(WebDriverBy::id('contact_submit'))->click();
    }
}
