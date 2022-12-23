<?php

namespace App\Tests\Repository;

use App\Entity\Album;
use App\Entity\Image;
use App\Repository\AlbumRepository;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AlbumRepositoryTest extends KernelTestCase
{
    private AlbumRepository $albumRepository;
    private ImageRepository $imageRepository;

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

    public function testPhotoIsSaveWithAlbum()
    {
        $photos = $this->imageRepository->findAll();
        $countPhotos = count($photos);

        $album = (new Album())
            ->setTitle('Test album')
            ->addPhoto((new Image())
                ->setName('Photo test'));

        $this->albumRepository->save($album, true);

        $photos = $this->imageRepository->findAll();
        $this->assertCount($countPhotos + 1, $photos);
    }

    public function testPhotoIsDeleteWithAlbum()
    {
        $albums = $this->albumRepository->findAll();
        $countAlbums = count($albums);
        $photos = $this->imageRepository->findAll();
        $countPhotos = count($photos);

        $this->albumRepository->remove($albums[rand(0, $countAlbums - 1)], true);

        $photos = $this->imageRepository->findAll();
        $this->assertCount($countPhotos - 1, $photos);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();

        $this->albumRepository = $kernel->getContainer()->get('doctrine')->getManager()->getRepository(Album::class);
        $this->imageRepository = $kernel->getContainer()->get('doctrine')->getManager()->getRepository(Image::class);
    }
}
