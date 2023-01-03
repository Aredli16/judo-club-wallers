<?php

namespace App\Tests\Entity;

use App\Entity\Album;
use App\Entity\AlbumContent;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class AlbumTest extends TestCase
{
    public function testIsTrue(): void
    {
        $createdAt = new DateTimeImmutable();
        $album = (new Album())
            ->setTitle('test_album')
            ->setSlug('test-album')
            ->setCreatedAt($createdAt);

        $this->assertEquals('test_album', $album->getTitle());
        $this->assertEquals('test-album', $album->getSlug());
        $this->assertEquals($createdAt, $album->getCreatedAt());
    }

    public function testIsFalse(): void
    {
        $album = (new Album())
            ->setTitle('test_album')
            ->setSlug('test-album');

        $this->assertNotEquals('false', $album->getTitle());
        $this->assertNotEquals('false', $album->getSlug());
        $this->assertNotEquals(new DateTimeImmutable(), $album->getCreatedAt());
    }

    public function testIsEmpty(): void
    {
        $album = new Album();

        $this->assertEmpty($album->getId());
        $this->assertEmpty($album->getTitle());
        $this->assertEmpty($album->getSlug());
    }

    public function testAddGetRemoveContent(): void
    {
        $album = new Album();
        $content = new AlbumContent();

        $this->assertEmpty($album->getContent());

        $album->addContent($content);
        $this->assertContains($content, $album->getContent());

        $album->removeContent($content);
        $this->assertEmpty($album->getContent());
    }
}