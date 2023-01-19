<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly UserRepository              $userRepository,
        private readonly UserPasswordHasherInterface $hasher
    )
    {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email'),
            TextField::new('password')
                ->onlyWhenCreating()
                ->setFormType(PasswordType::class),
            TextField::new('lastname'),
            TextField::new('firstname'),
            ImageField::new('avatar')
                ->setBasePath('uploads/media/users/content')
                ->setUploadDir('public/uploads/media/users/content')
                ->setRequired(false),
            TextField::new('phoneNumber'),
            ChoiceField::new('roles')
                ->setRequired(false)
                ->setFormTypeOptions(['multiple' => true])
                ->setTranslatableChoices(array_combine(array_keys($this->getParameter('security.role_hierarchy.roles')), array_keys($this->getParameter('security.role_hierarchy.roles'))))
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->upgradePassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function upgradePassword(user $user)
    {
        $this->userRepository->upgradePassword($user, $this->hasher->hashPassword($user, $user->getPassword()));
    }
}
