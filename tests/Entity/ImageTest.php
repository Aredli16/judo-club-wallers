<?php

namespace App\Tests\Entity;

use App\Entity\Album;
use App\Entity\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    public function testIsTrue(): void
    {
        $uploaded_at = new \DateTimeImmutable();
        $album = new Album();

        $image = (new Image())
            ->setName('image_test')
            ->setAlbum($album)
            ->setUploadedAt($uploaded_at);

        $this->assertEquals('image_test', $image->getName());
        $this->assertEquals($album, $image->getAlbum());
        $this->assertEquals($uploaded_at, $image->getUploadedAt());
    }

    public function testIsFalse(): void
    {
        $album = new Album();

        $image = (new Image())
            ->setName('image_test')
            ->setAlbum($album);

        $this->assertNotEquals('false', $image->getName());
        $this->assertNotEquals(new Album(), $image->getAlbum());
        $this->assertNotEquals(new \DateTimeImmutable(), $image->getUploadedAt());
    }

    public function testIsEmpty(): void
    {
        $image = new Image();

        $this->assertEmpty($image->getId());
        $this->assertEmpty($image->getName());
    }
}
