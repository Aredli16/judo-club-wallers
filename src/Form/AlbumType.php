<?php

namespace App\Form;

use App\Entity\Album;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

/**
 * @codeCoverageIgnore
 */
class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('photos', FileType::class, [
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
