<?php

namespace App\Tests\Entity;

use App\Entity\Article;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testArticleFields(): void
    {
        $this->assertClassHasAttribute('title', Article::class);
        $this->assertClassHasAttribute('content', Article::class);
        $this->assertClassHasAttribute('author', Article::class);
        $this->assertClassHasAttribute('image', Article::class);
        $this->assertClassHasAttribute('slug', Article::class);
        $this->assertClassHasAttribute('created_at', Article::class);
    }

    public function testArticleGettersAndSetters(): void
    {
        $test = new Article();
        $test->setId(1);
        $test->setTitle("test_title");
        $test->setContent("test_content");
        $test->setAuthor("test_author");
        $test->setImage("test_img");
        $test->setSlug("test_slug");
        $test->setCreatedAt(new DateTimeImmutable('2020-01-01'));

        $this->assertEquals("test_title", $test->getTitle());
        $this->assertEquals("test_content", $test->getContent());
        $this->assertEquals("test_author", $test->getAuthor());
        $this->assertEquals("test_img", $test->getImage());
        $this->assertEquals("test_slug", $test->getSlug());
        $this->assertEquals(new DateTimeImmutable('2020-01-01'), $test->getCreatedAt());
    }
}
