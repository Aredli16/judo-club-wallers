<?php

namespace App\Tests\Repository;

use App\Entity\Album;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AlbumRepositoryTest extends KernelTestCase
{
    private ObjectManager $entityManager;
    private $repository;

    public function testAlbumIsSave()
    {
        $albums = $this->repository->findAll();
        $countAlbums = count($albums);

        $album = (new Album())
            ->setTitle('Test');
        $this->entityManager->persist($album);
        $this->entityManager->flush();

        $albums = $this->repository->findAll();
        $this->assertCount($countAlbums + 1, $albums);
    }

    public function testAlbumIsDelete()
    {
        $albums = $this->repository->findAll();
        $countAlbums = count($albums);

        $this->entityManager->remove($albums[rand(0, $countAlbums - 1)]);
        $this->entityManager->flush();

        $albums = $this->repository->findAll();
        $this->assertCount($countAlbums - 1, $albums);
    }

    public function testASlugAfterPersist()
    {
        $album = (new Album())
            ->setTitle('Test album');
        $this->entityManager->persist($album);
        $this->entityManager->flush();

        $albums = $this->repository->findAll();
        $album = end($albums);

        $this->assertEquals('test-album-' . $album->getId(), $album->getSlug());

        $this->entityManager->remove($album);
        $this->entityManager->flush();
    }

    public function testPhotoIsSaveWithAlbum()
    {
        $photos = $this->entityManager->getRepository(Image::class)->findAll();
        $countPhotos = count($photos);

        $album = (new Album())
            ->setTitle('Test album')
            ->addPhoto((new Image())
                ->setName('Photo test'));

        $this->entityManager->persist($album);
        $this->entityManager->flush();

        $photos = $this->entityManager->getRepository(Image::class)->findAll();
        $this->assertCount($countPhotos + 1, $photos);
    }

    public function testPhotoIsDeleteWithAlbum()
    {
        $albums = $this->repository->findAll();
        $countAlbums = count($albums);
        $photos = $this->entityManager->getRepository(Image::class)->findAll();
        $countPhotos = count($photos);

        $this->entityManager->remove($albums[rand(0, $countAlbums - 1)]);
        $this->entityManager->flush();

        $photos = $this->entityManager->getRepository(Image::class)->findAll();
        $this->assertCount($countPhotos - 1, $photos);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->repository = $this->entityManager->getRepository(Album::class);
    }
}
