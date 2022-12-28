<?php

namespace App\Tests\Repository;

use App\Entity\Album;
use App\Entity\AlbumContent;
use App\Repository\AlbumContentRepository;
use App\Repository\AlbumRepository;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AlbumContentRepositoryTest extends KernelTestCase
{
    private AlbumContentRepository $albumContentRepository;
    private AlbumRepository $albumRepository;

    public function testContentCannotBeSaveWithoutAlbum(): void
    {
        $content = (new AlbumContent())
            ->setFileName('Test content');
        $this->expectException(NotNullConstraintViolationException::class);
        $this->albumContentRepository->save($content, true);
    }

    public function testRemoveContent(): void
    {
        $contents = $this->albumContentRepository->findAll();
        $countContent = count($contents);

        $album = (new Album())
            ->setTitle('Test album')
            ->addContent((new AlbumContent())
                ->setFileName('Content test'));
        $this->albumRepository->save($album, true);

        $contents = $this->albumContentRepository->findAll();
        $content = end($contents);
        $this->albumContentRepository->remove($content, true);
        $contents = $this->albumContentRepository->findAll();
        $this->albumRepository->remove($album, true);

        $this->assertCount($countContent, $contents);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();

        $this->albumContentRepository = $kernel->getContainer()->get('doctrine')->getManager()->getRepository(AlbumContent::class);
        $this->albumRepository = $kernel->getContainer()->get('doctrine')->getManager()->getRepository(Album::class);
    }
}
