<?php

namespace App\Tests;

use Facebook\WebDriver\WebDriverBy;
use Symfony\Component\Panther\PantherTestCase;

class LoginPantherTest extends PantherTestCase
{
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
}
