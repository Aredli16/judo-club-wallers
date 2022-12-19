<?php

namespace App\Tests;

use App\Entity\Article;
use PHPUnit\Framework\TestCase;

class ArticleUnitTest extends TestCase
{
    public function testArticleCreated(): void
    {
        $test = new Article();
        $test->setId(1);
        $test->setTitle("test_title");
        $this->assertClassHasAttribute('title', Article::class);
        $test->setContent("test_content");
        $this->assertClassHasAttribute('content', Article::class);
        $test->setAuthor("test_author");
        $this->assertClassHasAttribute('author', Article::class);
        $test->setImage("test_img");
        $this->assertClassHasAttribute('image', Article::class);
        $test->setSlug("test_slug");
        $this->assertClassHasAttribute('slug', Article::class);
        $this->assertClassHasAttribute('created_at', Article::class);
    }
}
