<?php

namespace App\Controller\Admin\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', FileType::class, [
                'mapped' => false,
                'multiple' => true,
                'attr' => [
                    'accept' => 'image/*'
                ],
                'constraints' => [
                    new All([
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => ['image/*'],
                            'mimeTypesMessage' => 'Veuillez sélectionner uniquement des fichiers images'
                        ])
                    ])
                ],
            ]);
    }
}
