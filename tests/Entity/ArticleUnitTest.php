<?php

namespace App\Tests;

use App\Entity\Article;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ArticleUnitTest extends TestCase
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
        $this->assertEquals("test_title", $test->getTitle());
        $test->setContent("test_content");
        $this->assertEquals("test_content", $test->getContent());
        $test->setAuthor("test_author");
        $this->assertEquals("test_author", $test->getAuthor());
        $test->setImage("test_img");
        $this->assertEquals("test_img", $test->getImage());
        $test->setSlug("test_slug");
        $this->assertEquals("test_slug", $test->getSlug());
        $test->setCreatedAt(new DateTimeImmutable('2020-01-01'));
        $this->assertEquals(new DateTimeImmutable('2020-01-01'), $test->getCreatedAt());
    }
}
