<?php

namespace App\Tests\Repository;

use App\Entity\Album;
use App\Entity\Image;
use App\Repository\AlbumRepository;
use App\Repository\ImageRepository;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ImageRepositoryTest extends KernelTestCase
{
    private ImageRepository $imageRepository;
    private AlbumRepository $albumRepository;

    public function testImageCannotBeSaveWithoutAlbum(): void
    {
        $image = (new Image())
            ->setName('Test image');
        $this->expectException(NotNullConstraintViolationException::class);
        $this->imageRepository->save($image, true);
    }

    public function testRemoveImage(): void
    {
        $images = $this->imageRepository->findAll();
        $countImages = count($images);

        $album = (new Album())
            ->setTitle('Test album')
            ->addPhoto((new Image())
                ->setName('Photo test'));
        $this->albumRepository->save($album, true);

        $photos = $this->imageRepository->findAll();
        $photo = end($photos);
        $this->imageRepository->remove($photo, true);
        $photos = $this->imageRepository->findAll();
        $this->albumRepository->remove($album, true);

        $this->assertCount($countImages, $photos);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();

        $this->imageRepository = $kernel->getContainer()->get('doctrine')->getManager()->getRepository(Image::class);
        $this->albumRepository = $kernel->getContainer()->get('doctrine')->getManager()->getRepository(Album::class);
    }
}
