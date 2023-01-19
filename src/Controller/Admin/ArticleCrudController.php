<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('content')
                ->onlyOnForms(),
            TextField::new('author')
                ->setDisabled(),
            DateTimeField::new('createdAt')
                ->onlyOnIndex(),
            ImageField::new('imageFileName')
                ->onlyOnForms()
                ->setUploadDir('public/uploads/media/articles/content')
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        return (new Article())
            ->setAuthor("Username");
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param Article $entityInstance
     */
    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $image = $this->getParameter('articles_directory') . '/' . $entityInstance->getImageFileName();
        if (is_file($image)) {
            unlink($image);
        }
        parent::deleteEntity($entityManager, $entityInstance);
    }
}
