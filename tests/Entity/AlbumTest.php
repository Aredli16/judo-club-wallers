<?php

namespace App\Tests\Entity;

use App\Entity\Album;
use App\Entity\Image;
use PHPUnit\Framework\TestCase;

class AlbumTest extends TestCase
{
    public function testIsTrue(): void
    {
        $createdAt = new \DateTimeImmutable();
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
        $this->assertNotEquals(new \DateTimeImmutable(), $album->getCreatedAt());
    }

    public function testIsEmpty(): void
    {
        $album = new Album();

        $this->assertEmpty($album->getId());
        $this->assertEmpty($album->getTitle(),);
        $this->assertEmpty($album->getSlug());
    }

    public function testAddGetRemovePhotos(): void
    {
        $album = new Album();
        $photo = new Image();

        $this->assertEmpty($album->getPhotos());

        $album->addPhoto($photo);
        $this->assertContains($photo, $album->getPhotos());

        $album->removePhoto($photo);
        $this->assertEmpty($album->getPhotos());
    }
}