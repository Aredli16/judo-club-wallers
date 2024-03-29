<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\ContentField;
use App\Entity\Album;
use App\Entity\AlbumContent;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AlbumCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Album::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title');
        yield DateTimeField::new('created_at')
            ->onlyOnIndex();
        yield ContentField::new('content');
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param Album $entityInstance
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        foreach ($this->getContext()->getRequest()->files->get('Album')['content']['content'] as $file) {
            $photo = (new AlbumContent())
                ->setFileName(md5(uniqid()) . '.' . $file->guessExtension());

            $file->move(
                $this->getParameter('albums_directory'),
                $photo->getFileName()
            );

            $entityInstance->addContent($photo);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param Album $entityInstance
     */
    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        foreach ($entityInstance->getContent() as $photo) {
            unlink($this->getParameter('albums_directory') . '/' . $photo->getFileName());
        }

        parent::deleteEntity($entityManager, $entityInstance);
    }
}
