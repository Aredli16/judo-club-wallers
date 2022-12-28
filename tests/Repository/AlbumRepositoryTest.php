<?php

namespace App\Tests\Repository;

use App\Entity\Album;
use App\Entity\AlbumContent;
use App\Repository\AlbumContentRepository;
use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AlbumRepositoryTest extends KernelTestCase
{
    private AlbumRepository $albumRepository;
    private AlbumContentRepository $albumContentRepository;

    public function testAlbumIsSave()
    {
        $albums = $this->albumRepository->findAll();
        $countAlbums = count($albums);

        $album = (new Album())
            ->setTitle('Test');
        $this->albumRepository->save($album, true);

        $albums = $this->albumRepository->findAll();
        $this->assertCount($countAlbums + 1, $albums);
    }

    public function testAlbumIsDelete()
    {
        $albums = $this->albumRepository->findAll();
        $countAlbums = count($albums);

        $this->albumRepository->remove($albums[rand(0, $countAlbums - 1)], true);

        $albums = $this->albumRepository->findAll();
        $this->assertCount($countAlbums - 1, $albums);
    }

    public function testASlugAfterPersist()
    {
        $album = (new Album())
            ->setTitle('Test album');
        $this->albumRepository->save($album, true);

        $albums = $this->albumRepository->findAll();
        $album = end($albums);

        $this->assertEquals('test-album-' . $album->getId(), $album->getSlug());

        $this->albumRepository->remove($album, true);
    }

    public function testContentIsSaveWithAlbum()
    {
        $content = $this->albumContentRepository->findAll();
        $countContent = count($content);

        $album = (new Album())
            ->setTitle('Test album')
            ->addContent((new AlbumContent())
                ->setFileName('Content test'));

        $this->albumRepository->save($album, true);

        $content = $this->albumContentRepository->findAll();
        $this->assertCount($countContent + 1, $content);
    }

    public function testContentIsDeleteWithAlbum()
    {
        $albums = $this->albumRepository->findAll();
        $countAlbums = count($albums);
        $content = $this->albumContentRepository->findAll();
        $countContent = count($content);

        $this->albumRepository->remove($albums[rand(0, $countAlbums - 1)], true);

        $content = $this->albumContentRepository->findAll();
        $this->assertCount($countContent - 1, $content);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();

        $this->albumRepository = $kernel->getContainer()->get('doctrine')->getManager()->getRepository(Album::class);
        $this->albumContentRepository = $kernel->getContainer()->get('doctrine')->getManager()->getRepository(AlbumContent::class);
    }
}
