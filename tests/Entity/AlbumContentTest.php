<?php

namespace App\Tests\Entity;

use App\Entity\Album;
use App\Entity\AlbumContent;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class AlbumContentTest extends TestCase
{
    public function testIsTrue(): void
    {
        $uploaded_at = new DateTimeImmutable();
        $album = new Album();

        $content = (new AlbumContent())
            ->setFileName('content_test')
            ->setAlbum($album)
            ->setUploadedAt($uploaded_at);

        $this->assertEquals('content_test', $content->getFileName());
        $this->assertEquals($album, $content->getAlbum());
        $this->assertEquals($uploaded_at, $content->getUploadedAt());
    }

    public function testIsFalse(): void
    {
        $album = new Album();

        $content = (new AlbumContent())
            ->setFileName('content_test')
            ->setAlbum($album);

        $this->assertNotEquals('false', $content->getFileName());
        $this->assertNotEquals(new Album(), $content->getAlbum());
        $this->assertNotEquals(new DateTimeImmutable(), $content->getUploadedAt());
    }

    public function testIsEmpty(): void
    {
        $content = new AlbumContent();

        $this->assertEmpty($content->getId());
        $this->assertEmpty($content->getFileName());
    }
}
